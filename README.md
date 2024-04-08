# Panaly - Project Analyzer

This project targets to deliver an extendable tool to analyze a projects sourcecode for some metrics. Have a code
coverage report? Some baselines for static analyzer that you want to keep in mind? Just file system metrics? Get
them all together based on your custom configuration and get a reporting of your mind for it.

The plugin system ensures that it is possible to customize every step from the configuration to the collection of
the metrics and over to storage and reporting. Later on even more access with active event listening will be enabled
so that every plugin can form the way a projects analyzer tools bring their numbers together.

## Setup

> :warning: Open TODO - Work in Progress Project

## Usage

In default the CLI Command will search for a config file `panaly.dist.yaml` which can be overwritten by giving the
config file with the CLI Command like `vendor/bin/panaly -c my-own-config.yaml`.

## Example Configuration

<details>
  <summary>panaly.dist.yaml</summary>

  ```yaml
plugins: # Registered plugins that deliver single metrics that could be utilized for metric groups
    Namespace/Of/The/Project/FilesystemPlugin: ~ # registers a "filesystem_directory_count" and a "fielsystem_file_count" metric
    Namespace/Of/Another/Project/PHPStanBaselinePlugin: ~ # registers a simple "phpstan_baseline_total_count" metric
    I/Have/A/Storage/Engine/LocalJsonStoragePlugin: ~ # registers a "local_json" storage and also a "metric_history_timeframe" metric that shows from / to string of alltime metric reading
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
            fielsystem_file_count:
                title: "Total project files"
                paths:
                    - src
                    - tests
            i_am_a_custom_identifier:
                metric: fielsystem_file_count # This overwrites the key and is the metric to be utilized
                title: "Just test files"
                paths:
                    - src
                    - tests
    group3:
        title: Static Analysis Metrics"
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

As Panaly is building on a wide plugin system and is not delivering metric collecting, storaging and reporting features
by itself everything needs to be done by a plugin. Each plugin can be specialized to a single task or deliver a full
feature set from the metric collection over storage handling to reporting generation.

In a result the plugins are the most basic thing to configure for a Panaly run. Every plugin has a base class that is
configuring how the plugin want to be utilized by Panaly and which features it delivers.

A Plugin can extend the class `Panaly\Plugin\BasePlugin` to not have to implement all methods for itself as the methods
are independently called from each other and nothing will happen when they are empty.

The following methods are available.

| Method                  | Description                                                                                                                                                                                   |
|-------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `initialize`            | Mainly usage idea currently is to register event listeners to the events that are triggered during the runtime of a Panaly run.                                                               |
| `getAvailableMetrics`   | Return a list of `Panaly\Plugin\Plugin\Metric` implementing classes to be used as metric collectors.                                                                                          |
| `getAvailableStorages`  | Return a list of `Panaly\Plugin\Plugin\Storage` implementing classes that will take the metric collection result and handle storage tasks.                                                    |
| `getAvailableReporting` | Return a list of `Panaly\Plugin\Plugin\Reporting` implementing classes that will take the metric collection result and generate some kind of reporting that can then be utilized by the user. |

## Events

The event section is work in progress as there is currently no real way to register an event listener but that will
become available later so that plugins are also enabled to hook into the events instead of delivering metrics,
reporting or storages to the process.

| Event                                                      | Description                                                                                                                                                                                                                                                                                              |
|------------------------------------------------------------|:---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Panaly\Configuration\ConfigurationFile\ConfigurationLoaded | The event is dispatched directly after the `ConfigurationFile` was loaded. It allows to overwrite the full configuration by delivering a new instance that will then be taken for the process.                                                                                                           |
| Panaly\Configuration\ConfigurationFile\RuntimeLoaded       | After the configuration was fully loaded and converted to the `RuntimeConfiguration` this event is triggered, it is the last possibility to change the metric running process.                                                                                                                           |
| Panaly\Configuration\ConfigurationFile\MetricResultCreated | When the collection, or execution, of configured metric groups is finished the event is triggered with all information and the result can be modified before the storage and reporting runs. The full environment is given her with the `ConfigurationFile`, the `RuntimeConfiguration` and the `Result` |

## Thanks and License

**Panaly - Project Analyzer** © 2024+, Denis Zunke. Released utilizing the [MIT License](https://mit-license.org/).

Inspired By [PHPMetrics](https://phpmetrics.github.io/website/) - Thanks for your Tool!

> GitHub [@dzunke](https://github.com/DZunke) &nbsp;&middot;&nbsp;
> Twitter [@DZunke](https://twitter.com/DZunke)
