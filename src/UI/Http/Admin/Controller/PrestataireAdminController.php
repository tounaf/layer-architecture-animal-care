<?php

namespace UI\Http\Admin\Controller;

use Application\Prestataire\Command\CreerPrestataireCommand;
use Application\Prestataire\Command\ModifierPrestataireCommand;
use Application\Prestataire\Command\CreerServiceProposeCommand;
use Application\Prestataire\Command\ModifierServiceProposeCommand;
use Application\Prestataire\Handler\CreerPrestataireHandler;
use Application\Prestataire\Handler\ModifierPrestataireHandler;
use Application\Prestataire\Handler\CreerServiceProposeHandler;
use Application\Prestataire\Handler\ModifierServiceProposeHandler;
use Domain\Prestataire\Repository\PrestataireRepositoryInterface;
use Domain\Prestataire\Repository\ServiceProposeRepositoryInterface;
use Domain\Service\Repository\ServiceRepositoryInterface;
use Domain\Shared\ValueObject\PrestataireId;
use Domain\Prestataire\ValueObject\ServiceProposeId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use UI\Http\Admin\Form\PrestataireType;
use UI\Http\Admin\Form\ServiceProposeType;

#[Route('/admin/prestataire', name: 'admin_prestataire_')]
class PrestataireAdminController extends AbstractController
{
    public function __construct(
        private PrestataireRepositoryInterface $repository,
        private ServiceProposeRepositoryInterface $serviceProposeRepository,
        private ServiceRepositoryInterface $serviceRepository
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/prestataire/index.html.twig', [
            'prestataires' => $this->repository->findAll()
        ]);
    }

    #[Route('/nouveau', name: 'new')]
    public function new(Request $request, CreerPrestataireHandler $handler): Response
    {
        $form = $this->createForm(PrestataireType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new CreerPrestataireCommand(
                $data['nomStructure'],
                $data['nomContact'],
                $data['prenomContact'],
                $data['profession'],
                $data['valideParAdmin'] ?? false
            );

            $handler($command);

            $this->addFlash('success', 'Prestataire créé avec succès');
            return $this->redirectToRoute('admin_prestataire_index');
        }

        return $this->render('admin/prestataire/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/detail', name: 'show')]
    public function show(string $id): Response
    {
        $prestataire = $this->repository->findById(PrestataireId::fromString($id));
        if (!$prestataire) {
            throw $this->createNotFoundException();
        }

        $servicesProposes = $this->serviceProposeRepository->findByPrestataire($prestataire->getId());

        return $this->render('admin/prestataire/show.html.twig', [
            'prestataire' => $prestataire,
            'servicesProposes' => $servicesProposes
        ]);
    }

    #[Route('/{id}/modifier', name: 'edit')]
    public function edit(string $id, Request $request, ModifierPrestataireHandler $handler): Response
    {
        $prestataire = $this->repository->findById(PrestataireId::fromString($id));
        if (!$prestataire) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(PrestataireType::class, [
            'nomStructure' => $prestataire->getNomStructure(),
            'nomContact' => $prestataire->getNomContact(),
            'prenomContact' => $prestataire->getPrenomContact(),
            'profession' => $prestataire->getProfession(),
            'valideParAdmin' => $prestataire->isValideParAdmin()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new ModifierPrestataireCommand(
                $id,
                $data['nomStructure'],
                $data['nomContact'],
                $data['prenomContact'],
                $data['profession'],
                $data['valideParAdmin'] ?? false
            );

            $handler($command);

            $this->addFlash('success', 'Prestataire modifié avec succès');
            return $this->redirectToRoute('admin_prestataire_index');
        }

        return $this->render('admin/prestataire/edit.html.twig', [
            'form' => $form->createView(),
            'prestataire' => $prestataire
        ]);
    }

    #[Route('/{id}/service/nouveau', name: 'service_new')]
    public function newService(string $id, Request $request, CreerServiceProposeHandler $handler): Response
    {
        $prestataire = $this->repository->findById(PrestataireId::fromString($id));
        if (!$prestataire) {
             throw $this->createNotFoundException();
        }

        $form = $this->createForm(ServiceProposeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new CreerServiceProposeCommand(
                $id,
                $data['serviceId'],
                $data['actif'] ?? true,
                $data['description']
            );

            $handler($command);

            $this->addFlash('success', 'Service ajouté au prestataire');
            return $this->redirectToRoute('admin_prestataire_show', ['id' => $id]);
        }

        return $this->render('admin/prestataire/service_new.html.twig', [
            'form' => $form->createView(),
            'prestataire' => $prestataire
        ]);
    }

    #[Route('/service/{id}/detail', name: 'service_show')]
    public function showService(string $id): Response
    {
        $servicePropose = $this->serviceProposeRepository->findById(ServiceProposeId::fromString($id));
        if (!$servicePropose) {
            throw $this->createNotFoundException();
        }

        $prestataire = $this->repository->findById($servicePropose->getPrestataireId());
        $service = $this->serviceRepository->findById($servicePropose->getServiceId());

        return $this->render('admin/prestataire/service_show.html.twig', [
            'servicePropose' => $servicePropose,
            'prestataire' => $prestataire,
            'service' => $service
        ]);
    }

    #[Route('/service/{id}/modifier', name: 'service_edit')]
    public function editService(string $id, Request $request, ModifierServiceProposeHandler $handler): Response
    {
        $servicePropose = $this->serviceProposeRepository->findById(ServiceProposeId::fromString($id));
        if (!$servicePropose) {
             throw $this->createNotFoundException();
        }

        $form = $this->createForm(ServiceProposeType::class, [
            'serviceId' => (string) $servicePropose->getServiceId(),
            'actif' => $servicePropose->isActif(),
            'description' => $servicePropose->getDescription()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new ModifierServiceProposeCommand(
                $id,
                $data['serviceId'],
                $data['actif'] ?? false,
                $data['description']
            );

            $handler($command);

            $this->addFlash('success', 'Service proposé modifié');
            return $this->redirectToRoute('admin_prestataire_show', ['id' => (string) $servicePropose->getPrestataireId()]);
        }

        return $this->render('admin/prestataire/service_edit.html.twig', [
            'form' => $form->createView(),
            'servicePropose' => $servicePropose
        ]);
    }

    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'])]
    public function delete(string $id, Request $request): Response
    {
        $prestataire = $this->repository->findById(PrestataireId::fromString($id));
        if ($prestataire && $this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $this->repository->delete($prestataire);
            $this->addFlash('success', 'Prestataire supprimé');
        }

        return $this->redirectToRoute('admin_prestataire_index');
    }
}
