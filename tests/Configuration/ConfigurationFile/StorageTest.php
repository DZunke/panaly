<?php

declare(strict_types=1);

namespace Panaly\Test\Configuration\ConfigurationFile;

use Panaly\Configuration\ConfigurationFile\Storage;
use Panaly\Configuration\Exception\InvalidConfigurationFile;
use PHPUnit\Framework\TestCase;

class StorageTest extends TestCase
{
    public function testThatTheObjectCanBeBuild(): void
    {
        $storage = new Storage('foo', []);

        self::assertSame('foo', $storage->identifier);
        self::assertSame([], $storage->options);
    }

    public function testThatTheStorageMustHaveAnIdentifier(): void
    {
        $this->expectException(InvalidConfigurationFile::class);
        $this->expectExceptionMessage('A storage configuration must have an non-empty name.');

        new Storage('', []);
    }
}
