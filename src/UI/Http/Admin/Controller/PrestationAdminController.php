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
        private ServiceRepositoryInterface $serviceRepository
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/prestation/index.html.twig', [
            'prestations' => $this->repository->findAll()
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

        return $this->render('admin/prestation/show.html.twig', [
            'prestation' => $prestation,
            'rdv' => $rdv,
            'service' => $service
        ]);
    }

    #[Route('/nouveau-depuis-rdv/{rdvId}', name: 'new_from_rdv')]
    public function newFromRdv(string $rdvId, Request $request, RealiserPrestationHandler $handler): Response
    {
        $rdv = $this->rendezVousRepository->findById(RendezVousId::fromString($rdvId));
        if (!$rdv) {
            throw $this->createNotFoundException();
        }

        // Pour la démonstration, on valide directement sans formulaire complexe
        // Dans un vrai projet, on utiliserait un PrestationType pour saisir le coût final
        if ($request->isMethod('POST')) {
            $command = new RealiserPrestationCommand(
                $rdvId,
                (string) $request->request->get('serviceProposeId'),
                new \DateTimeImmutable(),
                (float) $request->request->get('coutTotal')
            );

            $handler($command);

            $this->addFlash('success', 'Prestation validée et carnet de santé mis à jour');
            return $this->redirectToRoute('admin_prestation_index');
        }

        return $this->render('admin/prestation/new_from_rdv.html.twig', [
            'rdv' => $rdv
        ]);
    }
}
