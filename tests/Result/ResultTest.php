<?php

declare(strict_types=1);

namespace Panaly\Test\Result;

use DateTimeInterface;
use Panaly\Result\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testTheResultConvertedToArrayContainsACreationDateTime(): void
    {
        $result        = new Result();
        $resultAsArray = $result->toArray();

        self::assertArrayHasKey('createdAt', $resultAsArray);
        self::assertIsString($resultAsArray['createdAt']);
        self::assertSame($result->getCreateAt()->format(DateTimeInterface::ATOM), $resultAsArray['createdAt']);
    }
}
