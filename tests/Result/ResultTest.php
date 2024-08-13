<?php

declare(strict_types=1);

namespace Panaly\Test\Result;

use DateTimeInterface;
use Panaly\Result\Group;
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

    public function testAddGroup(): void
    {
        $result = new Result();
        $group  = new Group('identifier', 'title', []);
        $result->addGroup($group);

        self::assertCount(1, $result->getGroups());
        self::assertSame($group, $result->getGroups()[0]);
    }

    public function testGetGroups(): void
    {
        $group1 = new Group('identifier1', 'title1', []);
        $group2 = new Group('identifier2', 'title2', []);
        $result = new Result();
        $result->addGroup($group1);
        $result->addGroup($group2);

        $groups = $result->getGroups();
        self::assertCount(2, $groups);
        self::assertSame($group1, $groups[0]);
        self::assertSame($group2, $groups[1]);
    }

    public function testToArrayWithGroups(): void
    {
        $group1 = new Group('identifier1', 'title1', []);
        $group2 = new Group('identifier2', 'title2', []);
        $result = new Result();
        $result->addGroup($group1);
        $result->addGroup($group2);

        $resultAsArray = $result->toArray();
        self::assertArrayHasKey('groups', $resultAsArray);
        self::assertCount(2, $resultAsArray['groups']);

        self::assertArrayHasKey('identifier1', $resultAsArray['groups']);
        self::assertArrayHasKey('identifier2', $resultAsArray['groups']);

        self::assertSame($group1->toArray(), $resultAsArray['groups']['identifier1']);
        self::assertSame($group2->toArray(), $resultAsArray['groups']['identifier2']);
    }
}
