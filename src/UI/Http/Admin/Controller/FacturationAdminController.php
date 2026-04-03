<?php

namespace UI\Http\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/facturation', name: 'admin_facturation_')]
class FacturationAdminController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/' . strtolower('Facturation') . '/index.html.twig');
    }
}
