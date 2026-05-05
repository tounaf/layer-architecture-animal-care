<?php

namespace UI\Http\Admin\Controller;

use Application\Animal\Command\CreerAnimalCommand;
use Application\Animal\Command\ModifierAnimalCommand;
use Application\Animal\Handler\CreerAnimalHandler;
use Application\Animal\Handler\ModifierAnimalHandler;
use Domain\Animal\Repository\AnimalRepositoryInterface;
use Domain\Client\Repository\ClientRepositoryInterface;
use Domain\Shared\ValueObject\AnimalId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use UI\Http\Admin\Form\AnimalType;

#[Route('/admin/animal', name: 'admin_animal_')]
class AnimalAdminController extends AbstractController
{
    public function __construct(
        private AnimalRepositoryInterface $repository,
        private ClientRepositoryInterface $clientRepository
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        $animals = $this->repository->findAll();
        $enhancedAnimals = [];

        foreach ($animals as $animal) {
            $proprietaireName = 'Inconnu';
            if ($animal->getProprietaireId()) {
                $client = $this->clientRepository->findById($animal->getProprietaireId());
                if ($client) {
                    $proprietaireName = $client->getPrenom() . ' ' . $client->getNom();
                }
            }

            $enhancedAnimals[] = [
                'animal' => $animal,
                'proprietaireName' => $proprietaireName
            ];
        }

        return $this->render('admin/animal/index.html.twig', [
            'enhancedAnimals' => $enhancedAnimals
        ]);
    }

    #[Route('/nouveau', name: 'new')]
    public function new(Request $request, CreerAnimalHandler $handler): Response
    {
        $form = $this->createForm(AnimalType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new CreerAnimalCommand(
                $data['nom'],
                $data['proprietaireId'],
                $data['espece'],
                $data['race'],
                $data['dateNaissance'],
                $data['poids']
            );

            $handler($command);

            $this->addFlash('success', 'Animal créé avec succès');
            return $this->redirectToRoute('admin_animal_index');
        }

        return $this->render('admin/animal/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/detail', name: 'show')]
    public function show(string $id): Response
    {
        $animal = $this->repository->findById(AnimalId::fromString($id));
        if (!$animal) {
            throw $this->createNotFoundException();
        }

        $proprietaireInfo = 'Inconnu';
        if ($animal->getProprietaireId()) {
            $client = $this->clientRepository->findById($animal->getProprietaireId());
            if ($client) {
                $proprietaireInfo = $client->getPrenom() . ' ' . $client->getNom() . ' (' . $client->getEmail() . ')';
            }
        }

        return $this->render('admin/animal/show.html.twig', [
            'animal' => $animal,
            'proprietaireInfo' => $proprietaireInfo
        ]);
    }

    #[Route('/{id}/modifier', name: 'edit')]
    public function edit(string $id, Request $request, ModifierAnimalHandler $handler): Response
    {
        $animal = $this->repository->findById(AnimalId::fromString($id));
        if (!$animal) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(AnimalType::class, [
            'nom' => $animal->getNom(),
            'proprietaireId' => (string) $animal->getProprietaireId(),
            'espece' => $animal->getEspece(),
            'race' => $animal->getRace(),
            'dateNaissance' => $animal->getDateNaissance(),
            'poids' => $animal->getPoids()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new ModifierAnimalCommand(
                $id,
                $data['nom'],
                $data['proprietaireId'],
                $data['espece'],
                $data['race'],
                $data['dateNaissance'],
                $data['poids']
            );

            $handler($command);

            $this->addFlash('success', 'Animal modifié avec succès');
            return $this->redirectToRoute('admin_animal_index');
        }

        return $this->render('admin/animal/edit.html.twig', [
            'form' => $form->createView(),
            'animal' => $animal
        ]);
    }

    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'])]
    public function delete(string $id, Request $request): Response
    {
        $animal = $this->repository->findById(AnimalId::fromString($id));
        if (!$animal) {
            throw $this->createNotFoundException();
        }

        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $this->repository->delete($animal);
            $this->addFlash('success', 'Animal supprimé avec succès');
        }

        return $this->redirectToRoute('admin_animal_index');
    }
}
