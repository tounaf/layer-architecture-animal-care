<?php

namespace Application\Prestation\Handler;

use Application\Prestation\Command\RealiserPrestationCommand;
use Domain\Prestation\Entity\Prestation;
use Domain\Prestation\Repository\PrestationRepositoryInterface;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\RendezVous\ValueObject\RendezVousId;
use Domain\Prestataire\ValueObject\ServiceProposeId;
use Domain\Care\Entity\CarnetSante;
use Domain\Care\Repository\CarnetSanteRepositoryInterface;
use Domain\Care\Enum\TypeEntree;

final class RealiserPrestationHandler
{
    public function __construct(
        private PrestationRepositoryInterface $prestationRepository,
        private RendezVousRepositoryInterface $rendezVousRepository,
        private CarnetSanteRepositoryInterface $carnetSanteRepository
    ) {
    }

    public function __invoke(RealiserPrestationCommand $command): void
    {
        $rdvId = RendezVousId::fromString($command->rendezVousId);
        $rdv = $this->rendezVousRepository->findById($rdvId);

        if (!$rdv) {
            throw new \InvalidArgumentException('Rendez-vous non trouvé');
        }

        // Créer la prestation
        $prestation = Prestation::creer(
            $rdvId,
            ServiceProposeId::fromString($command->serviceProposeId),
            $command->dateRealisation,
            $command->coutTotal
        );
        $this->prestationRepository->save($prestation);

        // Gérer le carnet de santé
        $animalId = $rdv->getAnimalId();
        $carnet = $this->carnetSanteRepository->findByAnimal($animalId);

        if (!$carnet) {
            $carnet = CarnetSante::creer($animalId);
        }

        // Ajouter une entrée automatique au carnet
        $carnet->ajouterEntree(
            TypeEntree::CONSULTATION,
            'Prestation réalisée',
            'Prestation effectuée suite au rendez-vous.',
            $rdv->getPrestataireId()
        );

        $this->carnetSanteRepository->save($carnet);
    }
}
