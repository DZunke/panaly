<?php

declare(strict_types=1);

namespace Panaly\Event;

use Panaly\Configuration\RuntimeConfiguration;

final class RuntimeLoaded
{
    public function __construct(
        public readonly RuntimeConfiguration $runtimeConfiguration,
    ) {
    }
}
