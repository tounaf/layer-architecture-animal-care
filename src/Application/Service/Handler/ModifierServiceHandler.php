<?php

namespace Application\Service\Handler;

use Application\Service\Command\ModifierServiceCommand;
use Domain\Service\Repository\ServiceCategorieRepositoryInterface;
use Domain\Service\Repository\ServiceRepositoryInterface;
use Domain\Service\ValueObject\ServiceCategorieId;
use Domain\Service\ValueObject\ServiceId;

final class ModifierServiceHandler
{
    public function __construct(
        private ServiceRepositoryInterface $serviceRepository,
        private ServiceCategorieRepositoryInterface $categorieRepository
    ) {
    }

    public function __invoke(ModifierServiceCommand $command): void
    {
        $service = $this->serviceRepository->findById(ServiceId::fromString($command->id));

        if (!$service) {
            throw new \InvalidArgumentException('Service non trouvé');
        }

        $categorie = $this->categorieRepository->findById(ServiceCategorieId::fromString($command->categorieId));

        if (!$categorie) {
            throw new \InvalidArgumentException('Catégorie non trouvée');
        }

        $service->modifier(
            $command->nom,
            $command->code,
            $categorie,
            $command->dureeDefaultMinutes,
            $command->necessiteAcompteDefault,
            $command->description,
            $command->actif
        );

        $this->serviceRepository->save($service);
    }
}
