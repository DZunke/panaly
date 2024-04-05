<?php

declare(strict_types=1);

namespace Panaly\Plugin\Plugin;

use Panaly\Result\Result;

interface Storage
{
    /** @return non-empty-string */
    public function getIdentifier(): string;

    /** @param array<string, mixed> $options */
    public function store(Result $result, array $options): void;
}
