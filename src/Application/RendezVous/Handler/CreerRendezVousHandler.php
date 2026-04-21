<?php

namespace Application\RendezVous\Handler;

use Application\RendezVous\Command\CreerRendezVousCommand;
use Domain\RendezVous\Entity\RendezVous;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\Shared\ValueObject\ClientId;
use Domain\Shared\ValueObject\AnimalId;
use Domain\Shared\ValueObject\PrestataireId;

class CreerRendezVousHandler
{
    public function __construct(
        private RendezVousRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreerRendezVousCommand $command): void
    {
        $rendezVous = RendezVous::creer(
            ClientId::fromString($command->clientId),
            AnimalId::fromString($command->animalId),
            PrestataireId::fromString($command->prestataireId),
            $command->dateRdv,
            $command->heureDebut,
            $command->dureeMinutes,
            $command->commentaires
        );

        $this->repository->save($rendezVous);
    }
}
