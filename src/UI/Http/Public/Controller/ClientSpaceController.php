<?php

namespace UI\Http\Public\Controller;

use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\Facture\Repository\FactureRepositoryInterface;
use Domain\Animal\Repository\AnimalRepositoryInterface;
use Domain\Client\Repository\ClientRepositoryInterface;
use Domain\User\Repository\UserRepositoryInterface;
use Domain\User\ValueObject\UserId;
use Domain\Shared\ValueObject\ClientId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;

#[Route('/mon-espace', name: 'public_client_')]
class ClientSpaceController extends AbstractController
{
    public function __construct(
        private Security $security,
        private UserRepositoryInterface $userRepository,
        private ClientRepositoryInterface $clientRepository,
        private RendezVousRepositoryInterface $rendezVousRepository,
        private FactureRepositoryInterface $factureRepository,
        private AnimalRepositoryInterface $animalRepository
    ) {}

    #[Route('', name: 'dashboard')]
    public function dashboard(): Response
    {
        $client = $this->getClient();
        if (!$client) return $this->redirectToRoute('public_home_index');

        $appointments = $this->rendezVousRepository->findAll(); // Filtrer normalement par client
        $animals = $this->animalRepository->findAll(); // Filtrer normalement par client

        // Filtrage simulé car les repositories ne supportent pas encore findByClient nativement
        $clientAppointments = array_filter($appointments, fn($rdv) => $rdv->getClientId()->equals($client->getId()));
        $clientAnimals = array_filter($animals, fn($animal) => $animal->getProprietaireId()->equals($client->getId()));

        return $this->render('public/client/dashboard.html.twig', [
            'client' => $client,
            'appointments' => $clientAppointments,
            'animals' => $clientAnimals
        ]);
    }

    #[Route('/factures', name: 'invoices')]
    public function invoices(): Response
    {
        $client = $this->getClient();
        if (!$client) return $this->redirectToRoute('public_home_index');

        $allFactures = $this->factureRepository->findAll();
        // Filtrage complexe via prestation -> rdv -> client
        // ... (Logique simplifiée pour l'interface)

        return $this->render('public/client/invoices.html.twig', [
            'client' => $client,
            'factures' => $allFactures
        ]);
    }

    #[Route('/profil', name: 'profile')]
    public function profile(): Response
    {
        $client = $this->getClient();
        return $this->render('public/client/profile.html.twig', ['client' => $client]);
    }

    private function getClient()
    {
        $user = $this->security->getUser();
        if (!$user) return null;

        $domainUser = $this->userRepository->findById(UserId::fromString($user->getUserIdentifier()));
        if (!$domainUser || !$domainUser->getMail()) return null;

        // On cherche le client par email (lien User <-> Client par email dans ce projet)
        return $this->clientRepository->findByEmail($domainUser->getMail());
    }
}
