<?php

namespace UI\Http\Admin\Controller;

use Application\Service\Command\CreerServiceCommand;
use Application\Service\Command\ModifierServiceCommand;
use Application\Service\Handler\CreerServiceHandler;
use Application\Service\Handler\ModifierServiceHandler;
use Domain\Service\Repository\ServiceRepositoryInterface;
use Domain\Service\ValueObject\ServiceId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use UI\Http\Admin\Form\ServiceType;

#[Route('/admin/service', name: 'admin_service_')]
class ServiceAdminController extends AbstractController
{
    public function __construct(
        private ServiceRepositoryInterface $repository
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/service/index.html.twig', [
            'services' => $this->repository->findAll()
        ]);
    }

    #[Route('/nouveau', name: 'new')]
    public function new(Request $request, CreerServiceHandler $handler): Response
    {
        $form = $this->createForm(ServiceType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new CreerServiceCommand(
                $data['nom'],
                $data['code'],
                $data['categorieId'],
                $data['dureeDefaultMinutes'],
                $data['necessiteAcompteDefault'],
                $data['description'],
                $form->get('montantTarif')->getData() ?? 0
            );

            $handler($command);

            $this->addFlash('success', 'Service créé avec succès');
            return $this->redirectToRoute('admin_service_index');
        }

        return $this->render('admin/service/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/detail', name: 'show')]
    public function show(string $id): Response
    {
        $service = $this->repository->findById(ServiceId::fromString($id));
        if (!$service) {
            throw $this->createNotFoundException();
        }

        return $this->render('admin/service/show.html.twig', [
            'service' => $service
        ]);
    }

    #[Route('/{id}/modifier', name: 'edit')]
    public function edit(string $id, Request $request, ModifierServiceHandler $handler): Response
    {
        $service = $this->repository->findById(ServiceId::fromString($id));
        if (!$service) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(ServiceType::class, [
            'nom' => $service->getNom(),
            'code' => $service->getCode(),
            'categorieId' => (string) $service->getCategorie()->getId(),
            'description' => $service->getDescription(),
            'dureeDefaultMinutes' => $service->getDureeDefaultMinutes(),
            'necessiteAcompteDefault' => $service->isNecessiteAcompteDefault(),
            'actif' => $service->isActif(),
            'montantTarif' => $service->getTarif()->getMontant()
        ], ['is_update' => true]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new ModifierServiceCommand(
                $id,
                $data['nom'],
                $data['code'],
                $data['categorieId'],
                $data['dureeDefaultMinutes'],
                $data['necessiteAcompteDefault'],
                $data['description'],
                $data['actif']
            );

            $handler($command);

            if ($montant = $form->get('montantTarif')->getData()) {
                 $service->mettreAJourTarif($montant);
                 $this->repository->save($service);
            }

            $this->addFlash('success', 'Service modifié avec succès');
            return $this->redirectToRoute('admin_service_index');
        }

        return $this->render('admin/service/edit.html.twig', [
            'form' => $form->createView(),
            'service' => $service
        ]);
    }

    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'])]
    public function delete(string $id, Request $request): Response
    {
        $service = $this->repository->findById(ServiceId::fromString($id));
        if (!$service) {
            throw $this->createNotFoundException();
        }

        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $this->repository->delete($service);
            $this->addFlash('success', 'Service supprimé avec succès');
        }

        return $this->redirectToRoute('admin_service_index');
    }
}
