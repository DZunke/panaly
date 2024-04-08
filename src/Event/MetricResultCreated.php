<?php

declare(strict_types=1);

namespace Panaly\Event;

use Panaly\Configuration\ConfigurationFile;
use Panaly\Configuration\RuntimeConfiguration;
use Panaly\Result\Result;

final class MetricResultCreated
{
    public function __construct(
        public readonly ConfigurationFile $configurationFile,
        public readonly RuntimeConfiguration $runtimeConfiguration,
        public readonly Result $result,
    ) {
    }
}
