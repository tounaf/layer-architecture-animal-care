<?php

namespace Application\Service\Handler;

use Application\Service\Command\CreerServiceCommand;
use Domain\Service\Entity\Service;
use Domain\Service\Repository\ServiceCategorieRepositoryInterface;
use Domain\Service\Repository\ServiceRepositoryInterface;
use Domain\Service\ValueObject\ServiceCategorieId;

final class CreerServiceHandler
{
    public function __construct(
        private ServiceRepositoryInterface $serviceRepository,
        private ServiceCategorieRepositoryInterface $categorieRepository
    ) {
    }

    public function __invoke(CreerServiceCommand $command): void
    {
        $categorie = $this->categorieRepository->findById(ServiceCategorieId::fromString($command->categorieId));

        if (!$categorie) {
            throw new \InvalidArgumentException('Catégorie non trouvée');
        }

        $service = Service::creer(
            $command->nom,
            $command->code,
            $categorie,
            $command->dureeDefaultMinutes,
            $command->necessiteAcompteDefault,
            $command->description
        );

        if ($command->montantTarif > 0) {
            $service->mettreAJourTarif($command->montantTarif);
        }

        $this->serviceRepository->save($service);
    }
}
