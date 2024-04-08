<?php

declare(strict_types=1);

namespace Panaly\Configuration\ConfigurationFile;

use Panaly\Configuration\Exception\InvalidConfigurationFile;

class Reporting
{
    public function __construct(
        public readonly string $identifier,
        public readonly array $options,
    ) {
        if ($this->identifier === '') {
            throw InvalidConfigurationFile::reportingMustNotHaveABlankName();
        }
    }
}
