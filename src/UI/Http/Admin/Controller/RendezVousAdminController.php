<?php

namespace UI\Http\Admin\Controller;

use Application\RendezVous\Command\ConfirmerRendezVousCommand;
use Application\RendezVous\Command\AnnulerRendezVousCommand;
use Application\RendezVous\Command\ReporterRendezVousCommand;
use Application\RendezVous\Handler\ConfirmerRendezVousHandler;
use Application\RendezVous\Handler\AnnulerRendezVousHandler;
use Application\RendezVous\Handler\ReporterRendezVousHandler;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/rendez-vous', name: 'admin_rendezvous_')]
class RendezVousAdminController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(RendezVousRepositoryInterface $rendezVousRepository): Response
    {
        return $this->render('admin/rendez_vous/index.html.twig', [
            'rendezVousList' => $rendezVousRepository->findAll(),
        ]);
    }

    #[Route('/{id}/confirmer', name: 'confirm', methods: ['POST'])]
    public function confirm(string $id, ConfirmerRendezVousHandler $handler): Response
    {
        try {
            $handler(new ConfirmerRendezVousCommand($id));
            $this->addFlash('success', 'Rendez-vous confirmé');
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('admin_rendezvous_index');
    }

    #[Route('/{id}/annuler', name: 'cancel', methods: ['POST'])]
    public function cancel(string $id, Request $request, AnnulerRendezVousHandler $handler): Response
    {
        $motif = $request->request->get('motif', 'Annulation par l\'administrateur');

        try {
            $handler(new AnnulerRendezVousCommand($id, $motif));
            $this->addFlash('success', 'Rendez-vous annulé');
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('admin_rendezvous_index');
    }

    #[Route('/{id}/reporter', name: 'reschedule', methods: ['POST'])]
    public function reschedule(string $id, Request $request, ReporterRendezVousHandler $handler): Response
    {
        $nouvelleDateStr = $request->request->get('date');
        $nouvelleHeure = $request->request->get('heure');

        if (!$nouvelleDateStr || !$nouvelleHeure) {
            $this->addFlash('error', 'Date et heure requises pour reporter');
            return $this->redirectToRoute('admin_rendezvous_index');
        }

        try {
            $handler(new ReporterRendezVousCommand(
                $id,
                new \DateTimeImmutable($nouvelleDateStr),
                $nouvelleHeure
            ));
            $this->addFlash('success', 'Rendez-vous reporté');
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('admin_rendezvous_index');
    }
}
