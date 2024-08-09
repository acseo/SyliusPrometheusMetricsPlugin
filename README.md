<p align="center">
    <a href="https://www.acseo.fr" target="_blank">
        <img src="[https://www.acseo.fr/assets/img/logo-200.png](https://www.acseo.fr/wp-content/uploads/2024/01/logo-1.png" alt="ACSEO" style="width: 300px"/>
    </a>
</p>
<h1 align="center">
Sylius Prometheus Metrics
<br />
    <a href="https://packagist.org/packages/acseo/sylius-prometheus-metrics-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/acseo/sylius-prometheus-metrics-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/acseo/sylius-prometheus-metrics-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/acseo/sylius-prometheus-metrics-plugin.svg" />
    </a>
</h1>

## Features

### Observability

We use the _artprima/prometheus-metrics-bundle_ (https://github.com/artprima/prometheus-metrics-bundle) bundle to collect metrics in the Prometheus format, which can then be used to build a dashboard with Grafana.
These metrics are visible at the **/metrics/prometheus** URL of the website.

Default metrics are generated. It is possible to create custom metrics to track "Business" data, such as the number of created orders or the order amount.

<p align="center">
	<img src="https://prometheus.io/assets/grafana_prometheus.png"/>
</p>


## Installation

1. Run `$ composer require acseo/sylius-prometheus-metrics-plugin`.

2. Add these few lines to the `config/state_machine/sylius_payment.yaml`

```yaml
winzou_state_machine:
   sylius_payment:
      callbacks:
         after:
            sylius_order_items_complete_collector:
               on: 'complete'
               do: ['@metrics.order_collector', 'incrementPrometheusCounters']
               args: ["object.getOrder()"]
```


## Installation without Symfony Flex 

1. Run `$ composer require acseo/sylius-prometheus-metrics-plugin`.

2. Enable the plugin in bundles.php
```php
<?php
// config/bundles.php

return [
    // ...
    Artprima\PrometheusMetricsBundle\ArtprimaPrometheusMetricsBundle::class => ['all' => true],
    Acseo\SyliusPrometheusMetricsPlugin\SyliusPrometheusMetricsPlugin::class => ['all' => true],
];
```

3. Add this file `config/packages/prometheus_metrics.yaml`

```yaml
artprima_prometheus_metrics:
    namespace: myapp
    storage: '%env(PROM_METRICS_DSN)%'

    ignored_routes:
        - prometheus_bundle_prometheus
        - _wdt

    # used to disable default application metrics
    #disable_default_metrics: false

    # Recommended to disable default metrics from promphp/prometheus_client_php
    # see https://github.com/PromPHP/prometheus_client_php/issues/62
    disable_default_promphp_metrics: true

    # used to enable console metrics
    #enable_console_metrics: false

when@test:
    artprima_prometheus_metrics:
        storage: in_memory
```


4. Add the metrics routes `config/routes/metrics.yaml`

```yaml
app_metrics:
    resource: '@ArtprimaPrometheusMetricsBundle/Resources/config/routing.xml'
```



5. Add environment variables 

```
###> artprima/prometheus-metrics-bundle ###
PROM_METRICS_DSN=apcu
###< artprima/prometheus-metrics-bundle ###
```
