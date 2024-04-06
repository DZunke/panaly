<?php

declare(strict_types=1);

namespace Panaly\Collector;

use Panaly\Configuration\ConfigurationFile;
use Panaly\Configuration\RuntimeConfiguration;
use Panaly\Result\Group;
use Panaly\Result\Metric;
use Panaly\Result\Result;

use function assert;

readonly class Collector
{
    public function __construct(
        private ConfigurationFile $configurationFile,
        private RuntimeConfiguration $runtimeConfiguration,
    ) {
    }

    public function collect(): Result
    {
        $result = new Result();
        foreach ($this->configurationFile->metricGroups as $executingGroup) {
            $title = $executingGroup->title;
            assert($title !== ''); // Ensured by validation of the object

            $group = new Group($title);

            foreach ($executingGroup->metrics as $executingMetric) {
                $metricHandler = $this->runtimeConfiguration->getMetric($executingMetric->identifier);
                $metricResult  = $metricHandler->calculate($executingMetric->options);

                $group->addMetric(new Metric(
                    $executingMetric->title ?? $metricHandler->getDefaultTitle(),
                    $metricResult,
                ));
            }

            $result->addGroup($group);
        }

        return $result;
    }
}
