<?php

declare(strict_types=1);

namespace Panaly\Event;

use Panaly\Configuration\RuntimeConfiguration;

final readonly class RuntimeLoaded
{
    public function __construct(
        public RuntimeConfiguration $runtimeConfiguration,
    ) {
    }
}
