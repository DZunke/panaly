<?php

declare(strict_types=1);

namespace Panaly\Configuration\ConfigurationFile;

use Panaly\Configuration\Exception\InvalidConfigurationFile;

readonly class Reporting
{
    public function __construct(
        public string $identifier,
        public array $options,
    ) {
        if ($this->identifier === '') {
            throw InvalidConfigurationFile::reportingMustNotHaveABlankName();
        }
    }
}
