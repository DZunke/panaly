<?php

declare(strict_types=1);

namespace Panaly\Event;

use Panaly\Configuration\ConfigurationFile;
use Panaly\Configuration\RuntimeConfiguration;
use Panaly\Result\Result;

final readonly class MetricResultCreated
{
    public function __construct(
        public ConfigurationFile $configurationFile,
        public RuntimeConfiguration $runtimeConfiguration,
        public Result $result,
    ) {
    }
}
