<?php

namespace UI\Http\Admin\Controller;

use Domain\Facture\Repository\FactureRepositoryInterface;
use Domain\Facture\ValueObject\FactureId;
use Domain\Prestation\Repository\PrestationRepositoryInterface;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\Client\Repository\ClientRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/facture', name: 'admin_facture_')]
class FactureAdminController extends AbstractController
{
    public function __construct(
        private FactureRepositoryInterface $factureRepository,
        private PrestationRepositoryInterface $prestationRepository,
        private RendezVousRepositoryInterface $rendezVousRepository,
        private ClientRepositoryInterface $clientRepository
    ) {}

    #[Route('', name: 'index')]
    public function index(): Response
    {
        $factures = $this->factureRepository->findAll();
        $enhancedFactures = [];

        foreach ($factures as $facture) {
            $clientName = 'Inconnu';
            $prestation = $this->prestationRepository->findById($facture->getPrestationId());
            if ($prestation) {
                $rdv = $this->rendezVousRepository->findById($prestation->getRendezVousId());
                if ($rdv) {
                    $client = $this->clientRepository->findById($rdv->getClientId());
                    if ($client) {
                        $clientName = $client->getPrenom() . ' ' . $client->getNom();
                    }
                }
            }

            $enhancedFactures[] = [
                'facture' => $facture,
                'clientName' => $clientName
            ];
        }

        return $this->render('admin/facture/index.html.twig', [
            'enhancedFactures' => $enhancedFactures
        ]);
    }
}
