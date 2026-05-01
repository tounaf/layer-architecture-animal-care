<?php

namespace Domain\User\Repository;

use Domain\User\Entity\Profile;
use Domain\User\ValueObject\ProfileId;

interface ProfileRepositoryInterface
{
    public function save(Profile $profile): void;
    public function findById(ProfileId $id): ?Profile;
    public function findAll(): array;
}
