<?php

namespace Application\Shared\Dashboard;

use Domain\Animal\Repository\AnimalRepositoryInterface;
use Domain\Client\Repository\ClientRepositoryInterface;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\User\Repository\UserRepositoryInterface;

final readonly class DashboardStatsProvider
{
    public function __construct(
        private AnimalRepositoryInterface $animalRepository,
        private ClientRepositoryInterface $clientRepository,
        private RendezVousRepositoryInterface $rendezVousRepository,
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @return array{
     *     total_users: int,
     *     upcoming_appointments: int,
     *     total_animals: int
     * }
     */
    public function getKpis(): array
    {
        return [
            'total_users' => $this->userRepository->countAll(),
            'upcoming_appointments' => $this->rendezVousRepository->countUpcoming(),
            'total_animals' => $this->animalRepository->countAll(),
        ];
    }

    /**
     * @return array<int, array{
     *     id: string,
     *     client: string,
     *     animal: string,
     *     date: string,
     *     time: string
     * }>
     */
    public function getUpcomingAppointments(int $limit = 5): array
    {
        $appointments = $this->rendezVousRepository->findUpcoming($limit);
        
        return array_map(function ($rdv) {
            $client = $this->clientRepository->findById($rdv->getClientId());
            $animal = $this->animalRepository->findById($rdv->getAnimalId());

            return [
                'id' => (string) $rdv->getId(),
                'date' => $rdv->getDateRdv()->format('d/m/Y'),
                'time' => $rdv->getPlageHoraire()->getDebut(),
                'client' => $client ? ($client->getPrenom() . ' ' . $client->getNom()) : 'Client inconnu',
                'animal' => $animal ? $animal->getNom() : 'Animal inconnu',
            ];
        }, $appointments);
    }

    /**
     * @return array<string, int>
     */
    public function getSpeciesRepartition(): array
    {
        return $this->animalRepository->getSpeciesRepartition();
    }
}
