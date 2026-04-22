<?php

namespace UI\Http\Rest\Controller;

use Application\RendezVous\Command\CreerRendezVousCommand;
use Application\RendezVous\Handler\CreerRendezVousHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/rendez-vous', name: 'api_rendez_vous_')]
class RendezVousRestController extends AbstractController
{
    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request, CreerRendezVousHandler $handler): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $command = new CreerRendezVousCommand(
                prestataireId: $data['prestataire_id'],
                serviceProposeId: $data['service_propose_id'],
                dateRdv: new \DateTimeImmutable($data['date_rdv']),
                heureDebut: $data['heure_debut'],
                dureeMinutes: (int) $data['duree_minutes'],
                commentaires: $data['commentaires'] ?? null,
                clientNom: $data['client']['nom'] ?? null,
                clientPrenom: $data['client']['prenom'] ?? null,
                clientEmail: $data['client']['email'] ?? null,
                clientTelephone: $data['client']['telephone'] ?? null,
                animalNom: $data['animal']['nom'] ?? null,
                animalEspece: $data['animal']['espece'] ?? null,
                clientId: $data['client_id'] ?? null,
                animalId: $data['animal_id'] ?? null
            );

            $handler($command);

            return new JsonResponse(['status' => 'success'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
