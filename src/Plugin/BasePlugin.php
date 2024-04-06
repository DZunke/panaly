<?php

declare(strict_types=1);

namespace Panaly\Plugin;

use Panaly\Plugin\Plugin\Metric;
use Panaly\Plugin\Plugin\Reporting;
use Panaly\Plugin\Plugin\Storage;

abstract class BasePlugin implements Plugin
{
    /** @return list<Metric> */
    public function getAvailableMetrics(): array
    {
        return [];
    }

    /** @return list<Storage> */
    public function getAvailableStorages(): array
    {
        return [];
    }

    /** @return list<Reporting> */
    public function getAvailableReporting(): array
    {
        return [];
    }
}