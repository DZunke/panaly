<?php

declare(strict_types=1);

namespace Panaly\Result;

class Result
{
    /** @var list<Group> */
    private array $groups = [];

    /** @return list<Group> */
    public function getGroups(): array
    {
        return $this->groups;
    }

    public function addGroup(Group $group): void
    {
        $this->groups[] = $group;
    }

    /** @return list<array{title: string, metrics: list<array{title: string, value: mixed}>}> */
    public function toArray(): array
    {
        $asArray = [];
        foreach ($this->groups as $group) {
            $asArray[] = $group->toArray();
        }

        return $asArray;
    }
}
