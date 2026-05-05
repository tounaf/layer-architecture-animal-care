<?php

namespace UI\Http\Admin\Controller;

use Application\Medicament\Command\CreerMedicamentCommand;
use Application\Medicament\Command\UpdateMedicamentCommand;
use Application\Medicament\Command\DeleteMedicamentCommand;
use Domain\Medicament\Repository\MedicamentRepositoryInterface;
use Domain\Medicament\ValueObject\MedicamentId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use UI\Http\Admin\Form\MedicamentType;

#[Route('/admin/medicament', name: 'admin_medicament_')]
class MedicamentAdminController extends AbstractController
{
    public function __construct(
        private MedicamentRepositoryInterface $medicamentRepository,
        private MessageBusInterface $bus
    ) {}

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/medicament/index.html.twig', [
            'medicaments' => $this->medicamentRepository->findAll()
        ]);
    }

    #[Route('/nouveau', name: 'new')]
    public function new(Request $request): Response
    {
        $form = $this->createForm(MedicamentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->bus->dispatch(new CreerMedicamentCommand(
                $data['nom'],
                $data['description'],
                $data['prixUnitaire'],
                $data['stockActuel']
            ));
            return $this->redirectToRoute('admin_medicament_index');
        }

        return $this->render('admin/medicament/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/modifier', name: 'edit')]
    public function edit(string $id, Request $request): Response
    {
        $medicament = $this->medicamentRepository->findById(MedicamentId::fromString($id));
        if (!$medicament) throw $this->createNotFoundException();

        $form = $this->createForm(MedicamentType::class, [
            'nom' => $medicament->getNom(),
            'description' => $medicament->getDescription(),
            'prixUnitaire' => $medicament->getPrixUnitaire(),
            'stockActuel' => $medicament->getStockActuel()
        ], ['is_edit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->bus->dispatch(new UpdateMedicamentCommand(
                $id,
                $data['nom'],
                $data['description'],
                $data['prixUnitaire']
            ));
            return $this->redirectToRoute('admin_medicament_index');
        }

        return $this->render('admin/medicament/edit.html.twig', [
            'form' => $form->createView(),
            'medicament' => $medicament
        ]);
    }

    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'])]
    public function delete(string $id, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $this->bus->dispatch(new DeleteMedicamentCommand($id));
        }
        return $this->redirectToRoute('admin_medicament_index');
    }
}
