<?php

declare(strict_types=1);

namespace Panaly\Collector;

use Panaly\Configuration\ConfigurationFile;
use Panaly\Configuration\RuntimeConfiguration;
use Panaly\Event\BeforeMetricCalculate;
use Panaly\Result\Group;
use Panaly\Result\Metric;
use Panaly\Result\Result;

use function assert;

class Collector
{
    public function __construct(
        private readonly ConfigurationFile $configurationFile,
        private readonly RuntimeConfiguration $runtimeConfiguration,
    ) {
    }

    public function collect(): Result
    {
        $this->runtimeConfiguration->getLogger()->debug('Start collecting metrics.');

        $result = new Result();
        foreach ($this->configurationFile->metricGroups as $executingGroup) {
            $this->runtimeConfiguration->getLogger()->debug(
                'Collecting group "{group}".',
                ['group' => $executingGroup->identifier],
            );

            $title = $executingGroup->title;
            assert($title !== ''); // Ensured by validation of the object

            $group = new Group($executingGroup->identifier, $title);

            foreach ($executingGroup->metrics as $executingMetric) {
                $this->runtimeConfiguration->getLogger()->debug(
                    'Calculate "{metric}" in group "{group}".',
                    ['group' => $executingGroup->identifier, 'metric' => $executingMetric->identifier],
                );

                $metricHandler = $this->runtimeConfiguration->getMetric($executingMetric->metric);

                $event = new BeforeMetricCalculate($executingMetric, $executingMetric->options);
                $this->runtimeConfiguration->getEventDispatcher()->dispatch($event);

                $metricResult = $metricHandler->calculate($event->getOptions());

                $group->addMetric(new Metric(
                    $executingMetric->identifier,
                    $executingMetric->title ?? $metricHandler->getDefaultTitle(),
                    $metricResult,
                ));
            }

            $result->addGroup($group);
        }

        $this->runtimeConfiguration->getLogger()->debug('Finished collecting metrics.');

        return $result;
    }
}
