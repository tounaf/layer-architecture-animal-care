<?php

namespace UI\Http\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use UI\Http\Admin\Form\LoginType;

#[Route('/admin/login', name: 'admin_login_')]
class LoginAdminController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        $form = $this->createForm(LoginType::class);

        return $this->render('admin/login/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
