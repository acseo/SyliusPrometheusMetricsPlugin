<?php

declare(strict_types=1);

namespace ACSEO\SyliusPrometheusMetricsPlugin\Collector;

use Prometheus\CollectorRegistry;
use Sylius\Component\Core\Model\OrderInterface;

class Order
{
    public function __construct(
        protected string $prometheusMetricsNamespace,
        protected CollectorRegistry $collectionRegistry
    ) {
    }

    public function incrementPrometheusCounters(OrderInterface $order): void
    {
        $orderCounter = $this->collectionRegistry->getOrRegisterCounter(
            $this->prometheusMetricsNamespace,
            'order_complete',
            'amount of completed orders',
            ['order']
        );
        $orderCounter->inc(['all']);

        $amountCounter = $this->collectionRegistry->getOrRegisterCounter(
            $this->prometheusMetricsNamespace,
            'order_amount',
            'amount of completed orders',
            ['order']
        );
        $amountCounter->incBy($order->getTotal() / 100, ['all']);
    }
}
