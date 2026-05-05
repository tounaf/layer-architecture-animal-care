<?php

namespace Application\Prestation\Handler;

use Application\Prestation\Command\RealiserPrestationCommand;
use Domain\Prestation\Entity\Prestation;
use Domain\Prestation\Repository\PrestationRepositoryInterface;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\RendezVous\ValueObject\RendezVousId;
use Domain\Prestataire\ValueObject\ServiceProposeId;
use Domain\Service\ValueObject\ServiceChampId;
use Domain\Care\Entity\CarnetSante;
use Domain\Care\Repository\CarnetSanteRepositoryInterface;
use Domain\Care\Enum\TypeEntree;
use Domain\Document\Entity\Document;
use Domain\Document\Repository\DocumentRepositoryInterface;
use Domain\Medicament\Repository\MedicamentRepositoryInterface;
use Domain\Medicament\ValueObject\MedicamentId;
use Application\Shared\Bus\EventBusInterface;

final class RealiserPrestationHandler
{
    public function __construct(
        private PrestationRepositoryInterface $prestationRepository,
        private RendezVousRepositoryInterface $rendezVousRepository,
        private CarnetSanteRepositoryInterface $carnetSanteRepository,
        private DocumentRepositoryInterface $documentRepository,
        private MedicamentRepositoryInterface $medicamentRepository,
        private EventBusInterface $eventBus
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

        // Gérer les champs dynamiques
        foreach ($command->valeursChamps as $champIdStr => $valeur) {
            $champId = ServiceChampId::fromString($champIdStr);

            if (is_array($valeur) && isset($valeur['file_info'])) {
                // C'est un fichier
                $fileInfo = $valeur['file_info'];
                $document = Document::creer(
                    (string) $prestation->getId(),
                    $fileInfo['type_document'],
                    $fileInfo['nom'],
                    $fileInfo['url'],
                    $fileInfo['mime'],
                    $fileInfo['taille'],
                    $fileInfo['description']
                );
                $this->documentRepository->save($document);

                $prestation->ajouterValeurChamp($champId, $fileInfo['url'], 'fichier', $document->getId());
            } else {
                $prestation->ajouterValeurChamp($champId, (string)$valeur, 'texte');
            }
        }

        $this->prestationRepository->save($prestation);

        // Dispatch events de prestation (ex: PrestationRealisee)
        foreach ($prestation->getEvents() as $event) {
            $this->eventBus->dispatch($event);
        }
        $prestation->clearEvents();

        // Gérer les médicaments prescrits
        foreach ($command->prescriptions as $prescription) {
            $medicament = $this->medicamentRepository->findById(MedicamentId::fromString($prescription['medicamentId']));
            if ($medicament) {
                $medicament->prescrire((int)$prescription['quantite']);
                $this->medicamentRepository->save($medicament);
            }
        }

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
            'Prestation effectuée suite au rendez-vous. Coût : ' . $command->coutTotal . ' EUR',
            $rdv->getPrestataireId()
        );

        $rdv->terminer();
        $this->rendezVousRepository->save($rdv);
        
        $this->carnetSanteRepository->save($carnet);

        // Dispatch events (ex: EntreeAjoutee)
        foreach ($carnet->getEvents() as $event) {
            $this->eventBus->dispatch($event);
        }
        $carnet->clearEvents();
    }
}
