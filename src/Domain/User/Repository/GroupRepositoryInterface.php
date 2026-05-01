<?php

namespace Domain\User\Repository;

use Domain\User\Entity\Group;
use Domain\User\ValueObject\GroupId;

interface GroupRepositoryInterface
{
    public function save(Group $group): void;
    public function findById(GroupId $id): ?Group;
    public function findAll(): array;
}
