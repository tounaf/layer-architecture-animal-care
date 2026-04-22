<?php

namespace Application\Client\Handler;

use Application\Client\Command\ModifierClientCommand;
use Domain\Client\Repository\ClientRepositoryInterface;
use Domain\Shared\ValueObject\ClientId;

final class ModifierClientHandler
{
    public function __construct(
        private ClientRepositoryInterface $repository
    ) {
    }

    public function __invoke(ModifierClientCommand $command): void
    {
        $client = $this->repository->findById(ClientId::fromString($command->id));

        if (!$client) {
            throw new \InvalidArgumentException('Client non trouvé');
        }

        $client->modifier(
            $command->nom,
            $command->prenom,
            $command->email,
            $command->telephone,
            $command->ville
        );

        $this->repository->save($client);
    }
}
