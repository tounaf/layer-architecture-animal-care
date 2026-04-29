<?php

namespace UI\Http\Admin\Controller;

use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
