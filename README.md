# Panaly - Project Analyzer

[![Build Status](https://img.shields.io/github/actions/workflow/status/DZunke/panaly/ci.yml)](https://github.com/DZunke/panaly/actions)
[![License](https://img.shields.io/github/license/DZunke/panaly)](https://mit-license.org/)

This project aims to deliver an extendable tool to analyze a project's source code for various metrics. Whether you have
a code coverage report, baselines for static analyzers, or file system metrics, Panaly can aggregate them based on your
custom configuration and provide comprehensive reporting.

The plugin system ensures customization at every step, from configuration to metric collection, storage, and reporting.
Future updates will enable active event listening, allowing plugins to further customize the analysis process.

## Features

- Extensible plugin system
- Customizable metric collection
- Comprehensive reporting

## Setup

> :warning: **Work in Progress Project**

Install the package using Composer:

```bash
composer require --dev panaly/panaly
```

Create a `panaly.dist.yaml` file and configure it based on the plugins you need. Without any plugins, no actions will be
performed. Refer to the example configuration in this repository for guidance.

## Usage

By default, the CLI command searches for a `panaly.dist.yaml` configuration file. You can specify a different
configuration file using the `-c` option:

```bash
vendor/bin/panaly -c my-own-config.yaml
```

## Curated List of Plugins

**Metric Plugins**

* [Quality Tool Baselines](https://github.com/DZunke/panaly-baseline-plugin)
* [Filesystem](https://github.com/DZunke/panaly-files)

**Storage Plugins**

* [JSON Timeline Storage](https://github.com/DZunke/panaly-json-timeline-storage)

**Reporting Plugins**

* [Markdown Report](https://github.com/DZunke/panaly-markdown-report)
* [Symfony Dump Output](https://github.com/DZunke/panaly-symfony-dump)

**Other Plugins**

* [CODEOWNERS Paths](https://github.com/DZunke/panaly-codeowners)

## Example Configuration

<details>
  <summary>panaly.dist.yaml</summary>

  ```yaml
# panaly.dist.yaml
plugins: # Registered plugins that deliver single metrics that could be utilized for metric groups
    Namespace/Of/The/Project/FilesystemPlugin: ~ # registers a "filesystem_directory_count" and a "filesystem_file_count" metric
    Namespace/Of/Another/Project/PHPStanBaselinePlugin: ~ # registers a simple "phpstan_baseline_total_count" metric
    I/Have/A/Storage/Engine/LocalJsonStoragePlugin: ~ # registers a "local_json" storage and also a "metric_history_timeframe" metric that shows from / to string of all-time metric reading
    My/Own/Plugin/HtmlReportPlugin: ~ # registers the "my_own_html_reporting" reporting that takes the result collection of the metrics and does something with it

groups:
    group1:
        title: "My Metrics"
        metrics:
            metric_history_timeframe:
                title: "Metrics in Storage (Timeframe)"
                storage: local_json
    group2:
        title: "Filesystem Metrics"
        metrics:
            filesystem_directory_count: ~
            filesystem_file_count:
                title: "Total project files"
                paths:
                    - src
                    - tests
            i_am_a_custom_identifier:
                metric: filesystem_file_count # This overwrites the key and is the metric to be utilized
                title: "Just test files"
                paths:
                    - src
                    - tests
    group3:
        title: "Static Analysis Metrics"
        metrics:
            phpstan_baseline_total_count:
                title: "PHPStan Debts"
                baseline: .baselines/phpstan-baseline.neon

storage:
    local_json:
        path: var/metric_storage

reporting:
    my_own_html_reporting: ~
  ```

</details>

## Plugins

Panaly relies on a wide plugin system and does not provide metric collection, storage, or reporting features by itself.
Each plugin can specialize in a single task or deliver a full feature set from metric collection to storage handling and
report generation.

Plugins are essential for configuring a Panaly run. Each plugin has a base class that defines how it interacts with 
Panaly and the features it provides. A plugin must implement the `Panaly\Plugin\Plugin interface`, which defines 
an `initialize` method.  

The plugin will receive the full application configuration, the specific configuration associated 
with it, and the runtime configuration where metrics, storage, and reports can be added. It also has access to the 
event dispatcher to register listeners/subscribers for customizations.  

A plugin example:

```php
<?php

declare(strict_types=1);

namespace MyNamespace;

use Panaly\Configuration\ConfigurationFile;
use Panaly\Configuration\RuntimeConfiguration;
use Panaly\Plugin\Plugin;

final class BaselinePlugin implements Plugin
{
    public function initialize(
        ConfigurationFile $configurationFile,
        RuntimeConfiguration $runtimeConfiguration,
        array $options,
    ): void {
        $runtimeConfiguration->addMetric(new MyMetric());
        $runtimeConfiguration->addReporting(new MyReport());
        $runtimeConfiguration->addStorage(new MyStorage());
    }
}
```


## Events

The event system is a work in progress. Future updates will allow plugins to register event listeners, enabling them to
hook into events beyond delivering metrics, reporting, or storage.

| Event                                                        | Description                                                                                                                                                                                                                                                       |
|--------------------------------------------------------------|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Panaly\Configuration\ConfigurationFile\BeforeMetricCalculate | Dispatched before a metric collection method is executed, allowing modification of metric options directly before execution.                                                                                                                                      |
| Panaly\Configuration\ConfigurationFile\ConfigurationLoaded   | Dispatched after the `ConfigurationFile` is loaded, allowing the full configuration to be overwritten by delivering a new instance.                                                                                                                               |
| Panaly\Configuration\ConfigurationFile\RuntimeLoaded         | Dispatched after the configuration is fully loaded and converted to the `RuntimeConfiguration`, providing the last opportunity to change the metric running process.                                                                                              |
| Panaly\Configuration\ConfigurationFile\MetricResultCreated   | Dispatched when the collection or execution of configured metric groups is finished, allowing modification of the result before storage and reporting. The full environment is provided, including the `ConfigurationFile`, `RuntimeConfiguration`, and `Result`. |

## Thanks and License

**Panaly - Project Analyzer** © 2024+, Denis Zunke. Released under the [MIT License](https://mit-license.org/).

Inspired by [PHPMetrics](https://phpmetrics.github.io/website/) - Thanks for your tool!

> GitHub [@dzunke](https://github.com/DZunke) &nbsp;&middot;&nbsp;
> Twitter [@DZunke](https://twitter.com/DZunke)
