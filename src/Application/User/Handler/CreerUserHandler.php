<?php

namespace Application\User\Handler;

use Application\User\Command\CreerUserCommand;
use Application\Shared\Bus\EventBusInterface;
use Domain\User\Entity\User;
use Domain\User\Repository\UserRepositoryInterface;

final readonly class CreerUserHandler
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {}

    public function __invoke(CreerUserCommand $command): void
    {
        $user = new User($command->id);
        $this->repository->save($user);
        $this->eventBus->dispatchAll($user->getEvents());
        $user->clearEvents();
    }
}
