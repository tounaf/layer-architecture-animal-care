<?php

namespace {{ namespace }};

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('{{ route_prefix }}', name: '{{ route_name_prefix }}')]
class {{ className }} extends AbstractController
{
    #[Route('', name: 'get_all', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(['message' => 'Welcome to {{ name }} {{ context }} REST API']);
    }
}
