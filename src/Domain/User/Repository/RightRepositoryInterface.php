<?php

namespace Domain\User\Repository;

use Domain\User\Entity\Right;
use Domain\User\ValueObject\RightId;

interface RightRepositoryInterface
{
    public function save(Right $right): void;
    public function findById(RightId $id): ?Right;
    public function findByCode(string $code): ?Right;
    public function findAll(): array;
}
