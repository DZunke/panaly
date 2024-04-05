<?php

declare(strict_types=1);

namespace Panaly\Test\Configuration\Exception;

use Panaly\Configuration\Exception\PluginLoadingFailed;
use PHPUnit\Framework\TestCase;
use Throwable;

class PluginLoadingFailedTest extends TestCase
{
    public function testInstantiationFailed(): void
    {
        $previous  = self::createStub(Throwable::class);
        $exception = PluginLoadingFailed::instantiationFailed('Foo/Bar', $previous);

        self::assertSame(
            'The plugin could not be instantiated, maybe an invalid construction?',
            $exception->getMessage(),
        );
        self::assertSame($previous, $exception->getPrevious());
    }
}
