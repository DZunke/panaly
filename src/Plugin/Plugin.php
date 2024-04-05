<?php

declare(strict_types=1);

namespace Panaly\Plugin;

use Panaly\Plugin\Plugin\Metric;
use Panaly\Plugin\Plugin\Reporting;
use Panaly\Plugin\Plugin\Storage;

interface Plugin
{
    /** @return list<Metric> */
    public function getAvailableMetrics(): array;

    /** @return list<Storage> */
    public function getAvailableStorages(): array;

    /** @return list<Reporting> */
    public function getAvailableReporting(): array;
}
