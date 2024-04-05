<?php

declare(strict_types=1);

namespace Panaly\Configuration\ConfigurationFile;

use Panaly\Configuration\Exception\InvalidConfigurationFile;

readonly class Metric
{
    public function __construct(
        public string $identifier,
        public string|null $title,
        public array $options,
    ) {
        if ($this->identifier === '') {
            throw InvalidConfigurationFile::metricMustNotHaveABlankName();
        }
    }
}
