<?php

declare(strict_types=1);

namespace Panaly\Result;

use DateTimeImmutable;
use DateTimeInterface;

class Result
{
    private readonly DateTimeImmutable $createAt;
    /** @var list<Group> */
    private array $groups = [];

    public function __construct()
    {
        $this->createAt = new DateTimeImmutable();
    }

    public function getCreateAt(): DateTimeImmutable
    {
        return $this->createAt;
    }

    /** @return list<Group> */
    public function getGroups(): array
    {
        return $this->groups;
    }

    public function addGroup(Group $group): void
    {
        $this->groups[] = $group;
    }

    /**
     * @return array{
     *     createdAt: non-falsy-string,
     *     groups: array<
     *      string,
     *      array{
     *           title: string,
     *           metrics: array<string, array{title: string, value: mixed}>
     *      }
     *     >
     * }
     */
    public function toArray(): array
    {
        $asArray = [
            'createdAt' => $this->createAt->format(DateTimeInterface::ATOM),
            'groups' => [],
        ];

        foreach ($this->groups as $group) {
            $asArray['groups'][$group->getIdentifier()] = $group->toArray();
        }

        return $asArray;
    }
}
