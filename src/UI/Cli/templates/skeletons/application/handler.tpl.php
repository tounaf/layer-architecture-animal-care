<?php

namespace Application\{{ name }}\Handler;

use Application\{{ name }}\Command\Creer{{ name }}Command;
use Application\Shared\Bus\EventBusInterface;
use Domain\{{ name }}\Entity\{{ name }};
use Domain\{{ name }}\Repository\{{ name }}RepositoryInterface;

final readonly class Creer{{ name }}Handler
{
    public function __construct(
        private {{ name }}RepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {}

    public function __invoke(Creer{{ name }}Command $command): void
    {
        ${{ variableName }} = new {{ name }}($command->id);
        $this->repository->save(${{ variableName }});
        $this->eventBus->dispatchAll(${{ variableName }}->getEvents());
        ${{ variableName }}->clearEvents();
    }
}
