<?php

namespace UI\Http\Admin\Controller;

use Application\User\Command\CreateRightCommand;
use Application\User\Command\UpdateRightCommand;
use Application\User\Command\DeleteRightCommand;
use Domain\User\Repository\RightRepositoryInterface;
use Domain\User\ValueObject\RightId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use UI\Http\Admin\Form\RightType;

#[Route('/admin/right', name: 'admin_right_')]
class RightAdminController extends AbstractController
{
    public function __construct(
        private RightRepositoryInterface $rightRepository,
        private MessageBusInterface $bus
    ) {}

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/right/index.html.twig', [
            'rights' => $this->rightRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request): Response
    {
        $form = $this->createForm(RightType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->bus->dispatch(new CreateRightCommand($data['rightName'], $data['rightCode']));
            return $this->redirectToRoute('admin_right_index');
        }

        return $this->render('admin/right/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(string $id): Response
    {
        $right = $this->rightRepository->findById(RightId::fromString($id));
        if (!$right) throw $this->createNotFoundException();
        return $this->render('admin/right/show.html.twig', ['right' => $right]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(string $id, Request $request): Response
    {
        $right = $this->rightRepository->findById(RightId::fromString($id));
        if (!$right) throw $this->createNotFoundException();

        $form = $this->createForm(RightType::class, [
            'rightName' => $right->getRightName(),
            'rightCode' => $right->getRightCode()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->bus->dispatch(new UpdateRightCommand($id, $data['rightName'], $data['rightCode']));
            return $this->redirectToRoute('admin_right_index');
        }

        return $this->render('admin/right/edit.html.twig', ['form' => $form->createView(), 'right' => $right]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(string $id, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $this->bus->dispatch(new DeleteRightCommand($id));
        }
        return $this->redirectToRoute('admin_right_index');
    }
}
