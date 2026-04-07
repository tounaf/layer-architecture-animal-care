<?php

namespace Application\Login\Handler;

use Application\Login\Command\CreerLoginCommand;
use Application\Shared\Bus\EventBusInterface;
use Domain\Login\Entity\Login;
use Domain\Login\Repository\LoginRepositoryInterface;

final readonly class CreerLoginHandler
{
    public function __construct(
        private LoginRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {}

    public function __invoke(CreerLoginCommand $command): void
    {
        $login = new Login($command->id);
        $this->repository->save($login);
        $this->eventBus->dispatchAll($login->getEvents());
        $login->clearEvents();
    }
}
