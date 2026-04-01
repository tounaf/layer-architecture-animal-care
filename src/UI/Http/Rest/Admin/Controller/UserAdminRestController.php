<?php

namespace UI\Http\Rest\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/admin/user', name: 'rest_admin_user_')]
class UserAdminRestController extends AbstractController
{
    #[Route('', name: 'get_all', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(['message' => 'Welcome to User Admin REST API']);
    }
}
