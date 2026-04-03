<?php

namespace UI\Http\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/entreprise', name: 'admin_entreprise_')]
class EntrepriseAdminController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/' . strtolower('Entreprise') . '/index.html.twig');
    }
}
