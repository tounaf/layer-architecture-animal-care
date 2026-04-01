<?php

namespace UI\Http\{{ context }}\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('{{ route }}', name: '{{ context_lower }}_{{ name_lower }}_')]
class {{ className }} extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('{{ context_lower }}/' . strtolower('{{ name }}') . '/index.html.twig');
    }
}
