<?php

declare(strict_types=1);

namespace ACSEO\SyliusPrometheusMetricsPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SyliusPrometheusMetricsPlugin extends Bundle
{
    use SyliusPluginTrait;
}
