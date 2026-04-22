<?php

namespace Application\Animal\Handler;

use Application\Animal\Command\ModifierAnimalCommand;
use Domain\Animal\Repository\AnimalRepositoryInterface;
use Domain\Shared\ValueObject\AnimalId;
use Domain\Shared\ValueObject\ClientId;

final class ModifierAnimalHandler
{
    public function __construct(
        private AnimalRepositoryInterface $repository
    ) {
    }

    public function __invoke(ModifierAnimalCommand $command): void
    {
        $animal = $this->repository->findById(AnimalId::fromString($command->id));

        if (!$animal) {
            throw new \InvalidArgumentException('Animal non trouvé');
        }

        $animal->modifier(
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
