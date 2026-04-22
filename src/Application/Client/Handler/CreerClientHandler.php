<?php

namespace Application\Client\Handler;

use Application\Client\Command\CreerClientCommand;
use Domain\Client\Entity\Client;
use Domain\Client\Repository\ClientRepositoryInterface;

final class CreerClientHandler
{
    public function __construct(
        private ClientRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreerClientCommand $command): void
    {
        $client = Client::creer(
            $command->nom,
            $command->prenom,
            $command->email,
            $command->telephone,
            $command->ville
        );

        $this->repository->save($client);
    }
}
