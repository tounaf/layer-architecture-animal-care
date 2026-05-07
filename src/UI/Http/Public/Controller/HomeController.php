<?php

namespace UI\Http\Public\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'public_home_')]
class HomeController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('public_client_dashboard');
        }
        return $this->redirectToRoute('admin_login_index');
    }
}
