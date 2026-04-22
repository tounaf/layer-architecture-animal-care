<?php

namespace Application\Animal\Handler;

use Application\Animal\Command\CreerAnimalCommand;
use Domain\Animal\Entity\Animal;
use Domain\Animal\Repository\AnimalRepositoryInterface;
use Domain\Shared\ValueObject\ClientId;

final class CreerAnimalHandler
{
    public function __construct(
        private AnimalRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreerAnimalCommand $command): void
    {
        $animal = Animal::creer(
            $command->nom,
            $command->espece,
            $command->race,
            $command->dateNaissance,
            ClientId::fromString($command->proprietaireId),
            $command->poids
        );

        $this->repository->save($animal);
    }
}
