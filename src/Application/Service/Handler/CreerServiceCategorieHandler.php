<?php

namespace Application\Service\Handler;

use Application\Service\Command\CreerServiceCategorieCommand;
use Domain\Service\Entity\ServiceCategorie;
use Domain\Service\Repository\ServiceCategorieRepositoryInterface;

final class CreerServiceCategorieHandler
{
    public function __construct(
        private ServiceCategorieRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreerServiceCategorieCommand $command): void
    {
        $categorie = ServiceCategorie::creer(
            $command->nom,
            $command->description,
            $command->icone,
            $command->ordreAffichage
        );

        $this->repository->save($categorie);
    }
}
