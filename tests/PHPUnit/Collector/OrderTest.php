<?php

namespace Tests\ACSEO\SyliusPrometheusMetricsPlugin\PHPUnit\Collector;

use ACSEO\SyliusPrometheusMetricsPlugin\Collector\Order;
use PHPUnit\Framework\TestCase;
use Prometheus\CollectorRegistry;
use Prometheus\Counter;
use Sylius\Component\Core\Model\OrderInterface;

class OrderTest extends TestCase
{
    public function testIncrementPrometheusCounters(): void
    {
        // Create mocks for OrderInterface, Counter, and CollectorRegistry
        $order = $this->createMock(OrderInterface::class);
        $counter = $this->createMock(Counter::class);
        $collectionRegistry = $this->createMock(CollectorRegistry::class);

        // Set up expectations for getOrRegisterCounter method
        $collectionRegistry->expects($this->exactly(2))
            ->method('getOrRegisterCounter')
            ->willReturn($counter);

        // Create an instance of the Order class
        $orderCollector = new Order('namespace', $collectionRegistry);

        // Set up expectation for the first call to inc
        $counter->expects($this->once())
            ->method('inc')
            ->with([0 => 'all']);

        // Set up expectation for the second call to incBy
        $counter->expects($this->once())
            ->method('incBy')
            ->with($order->getTotal(), [0 => 'all']);

        // Call the method under test
        $orderCollector->incrementPrometheusCounters($order);
    }
}
