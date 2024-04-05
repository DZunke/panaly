<?php

declare(strict_types=1);

namespace Panaly\Plugin\Plugin;

use Panaly\Result\Result;

interface Reporting
{
    /** @return non-empty-string */
    public function getIdentifier(): string;

    /** @param array<string, mixed> $options */
    public function report(Result $result, array $options): void;
}
