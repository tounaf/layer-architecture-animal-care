<?php

namespace Application\Service\Handler;

use Application\Service\Command\ModifierServiceCategorieCommand;
use Domain\Service\Repository\ServiceCategorieRepositoryInterface;
use Domain\Service\ValueObject\ServiceCategorieId;

final class ModifierServiceCategorieHandler
{
    public function __construct(
        private ServiceCategorieRepositoryInterface $repository
    ) {
    }

    public function __invoke(ModifierServiceCategorieCommand $command): void
    {
        $categorie = $this->repository->findById(ServiceCategorieId::fromString($command->id));

        if (!$categorie) {
            throw new \InvalidArgumentException('Catégorie non trouvée');
        }

        $categorie->modifier(
            $command->nom,
            $command->description,
            $command->icone,
            $command->ordreAffichage,
            $command->actif
        );

        $this->repository->save($categorie);
    }
}
