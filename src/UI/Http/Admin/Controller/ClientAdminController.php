<?php

namespace UI\Http\Admin\Controller;

use Application\Client\Command\CreerClientCommand;
use Application\Client\Command\ModifierClientCommand;
use Application\Client\Handler\CreerClientHandler;
use Application\Client\Handler\ModifierClientHandler;
use Domain\Client\Repository\ClientRepositoryInterface;
use Domain\Animal\Repository\AnimalRepositoryInterface;
use Domain\Shared\ValueObject\ClientId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use UI\Http\Admin\Form\ClientType;

#[Route('/admin/client', name: 'admin_client_')]
class ClientAdminController extends AbstractController
{
    public function __construct(
        private ClientRepositoryInterface $repository,
        private AnimalRepositoryInterface $animalRepository
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/client/index.html.twig', [
            'clients' => $this->repository->findAll()
        ]);
    }

    #[Route('/nouveau', name: 'new')]
    public function new(Request $request, CreerClientHandler $handler): Response
    {
        $form = $this->createForm(ClientType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new CreerClientCommand(
                $data['nom'],
                $data['prenom'],
                $data['email'],
                $data['telephone'],
                $data['ville']
            );

            $handler($command);

            $this->addFlash('success', 'Client créé avec succès');
            return $this->redirectToRoute('admin_client_index');
        }

        return $this->render('admin/client/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/detail', name: 'show')]
    public function show(string $id): Response
    {
        $client = $this->repository->findById(ClientId::fromString($id));
        if (!$client) {
            throw $this->createNotFoundException();
        }

        $animals = $this->animalRepository->findByProprietaire($client->getId());

        return $this->render('admin/client/show.html.twig', [
            'client' => $client,
            'animals' => $animals
        ]);
    }

    #[Route('/{id}/modifier', name: 'edit')]
    public function edit(string $id, Request $request, ModifierClientHandler $handler): Response
    {
        $client = $this->repository->findById(ClientId::fromString($id));
        if (!$client) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(ClientType::class, [
            'nom' => $client->getNom(),
            'prenom' => $client->getPrenom(),
            'email' => $client->getEmail(),
            'telephone' => $client->getTelephone(),
            'ville' => $client->getVille()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new ModifierClientCommand(
                $id,
                $data['nom'],
                $data['prenom'],
                $data['email'],
                $data['telephone'],
                $data['ville']
            );

            $handler($command);

            $this->addFlash('success', 'Client modifié avec succès');
            return $this->redirectToRoute('admin_client_index');
        }

        return $this->render('admin/client/edit.html.twig', [
            'form' => $form->createView(),
            'client' => $client
        ]);
    }

    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'])]
    public function delete(string $id, Request $request): Response
    {
        $client = $this->repository->findById(ClientId::fromString($id));
        if (!$client) {
            throw $this->createNotFoundException();
        }

        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $this->repository->delete($client);
            $this->addFlash('success', 'Client supprimé avec succès');
        }

        return $this->redirectToRoute('admin_client_index');
    }
}
