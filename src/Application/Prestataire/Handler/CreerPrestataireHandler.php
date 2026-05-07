<?php

namespace Application\Prestataire\Handler;

use Application\Prestataire\Command\CreerPrestataireCommand;
use Domain\Prestataire\Entity\Prestataire;
use Domain\Prestataire\Repository\PrestataireRepositoryInterface;

final class CreerPrestataireHandler
{
    public function __construct(
        private PrestataireRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreerPrestataireCommand $command): void
    {
        $prestataire = Prestataire::creer(
            $command->nomStructure,
            $command->nomContact,
            $command->prenomContact,
            $command->profession,
            $command->valideParAdmin
        );

        $this->repository->save($prestataire);
    }
}
