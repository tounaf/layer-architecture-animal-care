<?php

namespace Domain\User\Repository;

use Domain\User\Entity\User;
use Domain\User\ValueObject\UserId;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function findById(UserId $id): ?User;
    public function findByLogin(string $login): ?User;
    public function findByMail(string $mail): ?User;
    public function findAll(): array;
    public function delete(User $user): void;
    public function countAll(): int;
}
