<?php

namespace Application\RendezVous\Handler;

use Application\RendezVous\Command\CreerRendezVousCommand;
use Domain\RendezVous\Entity\RendezVous;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\Shared\ValueObject\ClientId;
use Domain\Shared\ValueObject\AnimalId;
use Domain\Shared\ValueObject\PrestataireId;
use Domain\Prestataire\ValueObject\ServiceProposeId;
use Domain\Client\Entity\Client;
use Domain\Client\Repository\ClientRepositoryInterface;
use Domain\Animal\Entity\Animal;
use Domain\Animal\Repository\AnimalRepositoryInterface;
use Application\Shared\Bus\EventBusInterface;

class CreerRendezVousHandler
{
    public function __construct(
        private RendezVousRepositoryInterface $repository,
        private ClientRepositoryInterface $clientRepository,
        private AnimalRepositoryInterface $animalRepository,
        private EventBusInterface $eventBus
    ) {
    }

    public function __invoke(CreerRendezVousCommand $command): void
    {
        $clientId = $command->clientId ? ClientId::fromString($command->clientId) : null;
        $animalId = $command->animalId ? AnimalId::fromString($command->animalId) : null;

        // Create client if not provided
        if (!$clientId && $command->clientEmail) {
            $client = Client::creer($command->clientNom, $command->clientPrenom, $command->clientEmail, $command->clientTelephone);
            $this->clientRepository->save($client);
            $clientId = $client->getId();
        }

        // Create animal if not provided
        if (!$animalId && $command->animalNom && $clientId) {
            $animal = Animal::creer($command->animalNom, $command->animalEspece, null, null, $clientId);
            $this->animalRepository->save($animal);
            $animalId = $animal->getId();
        }

        if (!$clientId || !$animalId) {
             throw new \InvalidArgumentException('Client et Animal sont requis (existants ou à créer)');
        }

        $rendezVous = RendezVous::creer(
            $clientId,
            $animalId,
            PrestataireId::fromString($command->prestataireId),
            ServiceProposeId::fromString($command->serviceProposeId),
            $command->dateRdv,
            $command->heureDebut,
            $command->dureeMinutes,
            $command->commentaires
        );

        $this->repository->save($rendezVous);

        foreach ($rendezVous->getEvents() as $event) {
            $this->eventBus->dispatch($event);
        }
        $rendezVous->clearEvents();
    }
}
