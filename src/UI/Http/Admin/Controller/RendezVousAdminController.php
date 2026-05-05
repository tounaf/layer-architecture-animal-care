<?php

namespace UI\Http\Admin\Controller;

use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\Client\Repository\ClientRepositoryInterface;
use Domain\Animal\Repository\AnimalRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/rendez-vous', name: 'admin_rendezvous_')]
class RendezVousAdminController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(
        RendezVousRepositoryInterface $rendezVousRepository,
        ClientRepositoryInterface $clientRepository,
        AnimalRepositoryInterface $animalRepository
    ): Response {
        $rendezVousList = $rendezVousRepository->findAll();

        $enhancedRdvList = [];
        foreach ($rendezVousList as $rdv) {
            $client = $clientRepository->findById($rdv->getClientId());
            $animal = $animalRepository->findById($rdv->getAnimalId());

            $enhancedRdvList[] = [
                'rdv' => $rdv,
                'clientName' => $client ? ($client->getPrenom() . ' ' . $client->getNom()) : 'Client inconnu',
                'animalName' => $animal ? $animal->getNom() : 'Animal inconnu'
            ];
        }

        return $this->render('admin/rendez_vous/index.html.twig', [
            'enhancedRdvList' => $enhancedRdvList,
        ]);
    }
}
