<?php

namespace UI\Http\Admin\Controller;

use Application\User\Command\CreateGroupCommand;
use Application\User\Command\UpdateGroupCommand;
use Application\User\Command\DeleteGroupCommand;
use Domain\User\Repository\GroupRepositoryInterface;
use Domain\User\ValueObject\GroupId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use UI\Http\Admin\Form\GroupType;

#[Route('/admin/group', name: 'admin_group_')]
class GroupAdminController extends AbstractController
{
    public function __construct(
        private GroupRepositoryInterface $groupRepository,
        private MessageBusInterface $bus
    ) {}

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/group/index.html.twig', [
            'groups' => $this->groupRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request): Response
    {
        $form = $this->createForm(GroupType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $rightIds = array_map(fn($r) => (string)$r->getId(), $data['rights']->toArray());
            $profileIds = array_map(fn($p) => (string)$p->getId(), $data['profiles']->toArray());

            $this->bus->dispatch(new CreateGroupCommand($data['groupName'], $rightIds, $profileIds));
            return $this->redirectToRoute('admin_group_index');
        }

        return $this->render('admin/group/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(string $id, Request $request): Response
    {
        $group = $this->groupRepository->findById(GroupId::fromString($id));
        if (!$group) throw $this->createNotFoundException();

        $form = $this->createForm(GroupType::class, [
            'groupName' => $group->getGroupName(),
            'rights' => $group->getRights(),
            'profiles' => $group->getProfiles()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $rightIds = array_map(fn($r) => (string)$r->getId(), $data['rights']->toArray());
            $profileIds = array_map(fn($p) => (string)$p->getId(), $data['profiles']->toArray());

            $this->bus->dispatch(new UpdateGroupCommand($id, $data['groupName'], $rightIds, $profileIds));
            return $this->redirectToRoute('admin_group_index');
        }

        return $this->render('admin/group/edit.html.twig', ['form' => $form->createView(), 'group' => $group]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(string $id): Response
    {
        $group = $this->groupRepository->findById(GroupId::fromString($id));
        if (!$group) throw $this->createNotFoundException();
        return $this->render('admin/group/show.html.twig', ['group' => $group]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(string $id, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $this->bus->dispatch(new DeleteGroupCommand($id));
        }
        return $this->redirectToRoute('admin_group_index');
    }
}
