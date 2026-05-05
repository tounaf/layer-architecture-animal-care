<?php

namespace UI\Http\Admin\Controller;

use Domain\Care\Repository\CarnetSanteRepositoryInterface;
use Domain\Animal\Repository\AnimalRepositoryInterface;
use Domain\Client\Repository\ClientRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/care', name: 'admin_care_')]
class CareAdminController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(
        CarnetSanteRepositoryInterface $carnetSanteRepository,
        AnimalRepositoryInterface $animalRepository,
        ClientRepositoryInterface $clientRepository
    ): Response {
        $carnets = $carnetSanteRepository->findAll();
        $enhancedCarnets = [];

        foreach ($carnets as $carnet) {
            $animal = $animalRepository->findById($carnet->getAnimalId());
            $animalName = 'Inconnu';
            $clientName = 'Inconnu';

            if ($animal) {
                $animalName = $animal->getNom();
                if ($animal->getProprietaireId()) {
                    $client = $clientRepository->findById($animal->getProprietaireId());
                    if ($client) {
                        $clientName = $client->getPrenom() . ' ' . $client->getNom();
                    }
                }
            }

            $enhancedCarnets[] = [
                'carnet' => $carnet,
                'animalName' => $animalName,
                'clientName' => $clientName
            ];
        }

        return $this->render('admin/care/index.html.twig', [
            'enhancedCarnets' => $enhancedCarnets
        ]);
    }
}
