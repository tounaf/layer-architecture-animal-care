<?php

namespace Application\Prestataire\Handler;

use Application\Prestataire\Command\ModifierPrestataireCommand;
use Domain\Prestataire\Repository\PrestataireRepositoryInterface;
use Domain\Shared\ValueObject\PrestataireId;

final class ModifierPrestataireHandler
{
    public function __construct(
        private PrestataireRepositoryInterface $repository
    ) {
    }

    public function __invoke(ModifierPrestataireCommand $command): void
    {
        $prestataire = $this->repository->findById(PrestataireId::fromString($command->id));

        if (!$prestataire) {
            throw new \InvalidArgumentException('Prestataire non trouvé');
        }

        $prestataire->modifier(
            $command->nomStructure,
            $command->nomContact,
            $command->prenomContact,
            $command->profession,
            $command->valideParAdmin
        );

        $this->repository->save($prestataire);
    }
}
