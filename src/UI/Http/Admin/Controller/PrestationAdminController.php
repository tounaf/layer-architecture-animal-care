<?php

namespace UI\Http\Admin\Controller;

use Application\Prestation\Command\RealiserPrestationCommand;
use Application\Prestation\Handler\RealiserPrestationHandler;
use Domain\Prestation\Repository\PrestationRepositoryInterface;
use Domain\Prestation\ValueObject\PrestationId;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\RendezVous\ValueObject\RendezVousId;
use Domain\Prestataire\Repository\ServiceProposeRepositoryInterface;
use Domain\Service\Repository\ServiceRepositoryInterface;
use Domain\Service\Repository\ServiceChampRepositoryInterface;
use Domain\Client\Repository\ClientRepositoryInterface;
use Domain\Animal\Repository\AnimalRepositoryInterface;
use Infrastructure\File\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/prestation', name: 'admin_prestation_')]
class PrestationAdminController extends AbstractController
{
    public function __construct(
        private PrestationRepositoryInterface $repository,
        private RendezVousRepositoryInterface $rendezVousRepository,
        private ServiceProposeRepositoryInterface $serviceProposeRepository,
        private ServiceRepositoryInterface $serviceRepository,
        private ServiceChampRepositoryInterface $champRepository,
        private ClientRepositoryInterface $clientRepository,
        private AnimalRepositoryInterface $animalRepository
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        $prestations = $this->repository->findAll();
        $enhancedPrestations = [];

        foreach ($prestations as $prestation) {
            $rdv = $this->rendezVousRepository->findById($prestation->getRendezVousId());
            $clientName = 'Client inconnu';
            $plageHoraire = 'N/A';

            if ($rdv) {
                $client = $this->clientRepository->findById($rdv->getClientId());
                if ($client) {
                    $clientName = $client->getPrenom() . ' ' . $client->getNom();
                }
                $plageHoraire = $rdv->getDateRdv()->format('d/m/Y') . ' (' . $rdv->getPlageHoraire()->getDebut() . ' - ' . $rdv->getPlageHoraire()->getFin() . ')';
            }

            $servicePropose = $this->serviceProposeRepository->findById($prestation->getServiceProposeId());
            $serviceName = 'Service inconnu';
            if ($servicePropose) {
                $service = $this->serviceRepository->findById($servicePropose->getServiceId());
                if ($service) {
                    $serviceName = $service->getNom();
                }
            }

            $enhancedPrestations[] = [
                'prestation' => $prestation,
                'clientName' => $clientName,
                'plageHoraire' => $plageHoraire,
                'serviceName' => $serviceName
            ];
        }

        return $this->render('admin/prestation/index.html.twig', [
            'enhancedPrestations' => $enhancedPrestations
        ]);
    }

    #[Route('/{id}/detail', name: 'show')]
    public function show(string $id): Response
    {
        $prestation = $this->repository->findById(PrestationId::fromString($id));
        if (!$prestation) {
            throw $this->createNotFoundException();
        }

        $rdv = $this->rendezVousRepository->findById($prestation->getRendezVousId());
        $servicePropose = $this->serviceProposeRepository->findById($prestation->getServiceProposeId());
        $service = $this->serviceRepository->findById($servicePropose->getServiceId());

        $clientInfo = 'Inconnu';
        $animalInfo = 'Inconnu';
        if ($rdv) {
            $client = $this->clientRepository->findById($rdv->getClientId());
            if ($client) {
                $clientInfo = $client->getPrenom() . ' ' . $client->getNom() . ' (' . $client->getEmail() . ')';
            }
            $animal = $this->animalRepository->findById($rdv->getAnimalId());
            if ($animal) {
                $animalInfo = $animal->getNom() . ' (' . ($animal->getEspece() ?: 'Espèce inconnue') . ')';
            }
        }

        return $this->render('admin/prestation/show.html.twig', [
            'prestation' => $prestation,
            'rdv' => $rdv,
            'service' => $service,
            'clientInfo' => $clientInfo,
            'animalInfo' => $animalInfo,
            'champs' => $this->champRepository->findAll()
        ]);
    }

    #[Route('/nouveau-depuis-rdv/{rdvId}', name: 'new_from_rdv')]
    public function newFromRdv(string $rdvId, Request $request, RealiserPrestationHandler $handler, FileUploader $uploader): Response
    {
        $rdv = $this->rendezVousRepository->findById(RendezVousId::fromString($rdvId));
        if (!$rdv) {
            throw $this->createNotFoundException();
        }

        $champs = $this->champRepository->findAll();

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('realiser_prestation', $request->request->get('_token'))) {
                 throw $this->createAccessDeniedException('Token CSRF invalide');
            }

            $valeursChamps = [];
            foreach ($champs as $champ) {
                $champIdStr = (string)$champ->getId();
                if ($champ->getTypeChamp() === 'file') {
                    $file = $request->files->get('champ_' . $champIdStr);
                    if ($file) {
                        try {
                            $fileInfo = $uploader->upload($file);
                            $fileInfo['type_document'] = $champ->getNom();
                            $fileInfo['description'] = $champ->getDescription();
                            $valeursChamps[$champIdStr] = ['file_info' => $fileInfo];
                        } catch (\InvalidArgumentException $e) {
                            $this->addFlash('error', $e->getMessage());
                            return $this->render('admin/prestation/new_from_rdv.html.twig', [
                                'rdv' => $rdv,
                                'champs' => $champs
                            ]);
                        }
                    }
                } else {
                    $valeursChamps[$champIdStr] = $request->request->get('champ_' . $champIdStr);
                }
            }

            $command = new RealiserPrestationCommand(
                $rdvId,
                (string) $rdv->getServiceProposeId(),
                new \DateTimeImmutable(),
                (float) $request->request->get('coutTotal'),
                $valeursChamps
            );

            $handler($command);

            $this->addFlash('success', 'Prestation validée et carnet de santé mis à jour');
            return $this->redirectToRoute('admin_prestation_index');
        }

        return $this->render('admin/prestation/new_from_rdv.html.twig', [
            'rdv' => $rdv,
            'champs' => $champs
        ]);
    }
}
