<?php

namespace Application\User\Handler;

use Application\User\Command\DeleteUserCommand;
use Domain\User\Repository\UserRepositoryInterface;
use Domain\User\ValueObject\UserId;

final class DeleteUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        $user = $this->userRepository->findById(UserId::fromString($command->id));
        if ($user) {
            $this->userRepository->delete($user);
        }
    }
}
