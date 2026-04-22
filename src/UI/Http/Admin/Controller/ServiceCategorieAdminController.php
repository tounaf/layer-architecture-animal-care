<?php

namespace UI\Http\Admin\Controller;

use Application\Service\Command\CreerServiceCategorieCommand;
use Application\Service\Command\ModifierServiceCategorieCommand;
use Application\Service\Handler\CreerServiceCategorieHandler;
use Application\Service\Handler\ModifierServiceCategorieHandler;
use Domain\Service\Repository\ServiceCategorieRepositoryInterface;
use Domain\Service\ValueObject\ServiceCategorieId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use UI\Http\Admin\Form\ServiceCategorieType;

#[Route('/admin/service-categorie', name: 'admin_service_categorie_')]
class ServiceCategorieAdminController extends AbstractController
{
    public function __construct(
        private ServiceCategorieRepositoryInterface $repository
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/service_categorie/index.html.twig', [
            'categories' => $this->repository->findAll()
        ]);
    }

    #[Route('/nouveau', name: 'new')]
    public function new(Request $request, CreerServiceCategorieHandler $handler): Response
    {
        $form = $this->createForm(ServiceCategorieType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new CreerServiceCategorieCommand(
                $data['nom'],
                $data['description'],
                $data['icone'],
                $data['ordreAffichage']
            );

            $handler($command);

            $this->addFlash('success', 'Catégorie créée avec succès');
            return $this->redirectToRoute('admin_service_categorie_index');
        }

        return $this->render('admin/service_categorie/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/detail', name: 'show')]
    public function show(string $id): Response
    {
        $categorie = $this->repository->findById(ServiceCategorieId::fromString($id));
        if (!$categorie) {
            throw $this->createNotFoundException();
        }

        return $this->render('admin/service_categorie/show.html.twig', [
            'categorie' => $categorie
        ]);
    }

    #[Route('/{id}/modifier', name: 'edit')]
    public function edit(string $id, Request $request, ModifierServiceCategorieHandler $handler): Response
    {
        $categorie = $this->repository->findById(ServiceCategorieId::fromString($id));
        if (!$categorie) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(ServiceCategorieType::class, [
            'nom' => $categorie->getNom(),
            'description' => $categorie->getDescription(),
            'icone' => $categorie->getIcone(),
            'ordreAffichage' => $categorie->getOrdreAffichage(),
            'actif' => $categorie->isActif()
        ], ['is_update' => true]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new ModifierServiceCategorieCommand(
                $id,
                $data['nom'],
                $data['description'],
                $data['icone'],
                $data['ordreAffichage'],
                $data['actif']
            );

            $handler($command);

            $this->addFlash('success', 'Catégorie modifiée avec succès');
            return $this->redirectToRoute('admin_service_categorie_index');
        }

        return $this->render('admin/service_categorie/edit.html.twig', [
            'form' => $form->createView(),
            'categorie' => $categorie
        ]);
    }

    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'])]
    public function delete(string $id, Request $request): Response
    {
        $categorie = $this->repository->findById(ServiceCategorieId::fromString($id));
        if (!$categorie) {
            throw $this->createNotFoundException();
        }

        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $this->repository->delete($categorie);
            $this->addFlash('success', 'Catégorie supprimée avec succès');
        }

        return $this->redirectToRoute('admin_service_categorie_index');
    }
}
