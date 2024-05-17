<?php

declare(strict_types=1);

namespace Panaly\Configuration\ConfigurationFile;

use Panaly\Configuration\Exception\InvalidConfigurationFile;

class Reporting
{
    /** @param array<string, mixed> $options */
    public function __construct(
        public readonly string $identifier,
        public readonly array $options,
    ) {
        if ($this->identifier === '') {
            throw InvalidConfigurationFile::reportingMustNotHaveABlankName();
        }
    }
}
