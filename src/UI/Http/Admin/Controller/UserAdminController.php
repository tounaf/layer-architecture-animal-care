<?php

namespace UI\Http\Admin\Controller;

use Application\User\Command\RegisterUserCommand;
use Application\User\Command\UpdateUserCommand;
use Application\User\Command\DeleteUserCommand;
use Domain\User\Repository\UserRepositoryInterface;
use Domain\User\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use UI\Http\Admin\Form\UserType;

#[Route('/admin/user', name: 'admin_user_')]
class UserAdminController extends AbstractController
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private MessageBusInterface $bus
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $this->userRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request): Response
    {
        $form = $this->createForm(UserType::class, null, ['is_new' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $groupIds = array_map(fn($g) => (string)$g->getId(), $data['groups']->toArray());
            $profileIds = array_map(fn($p) => (string)$p->getId(), $data['profiles']->toArray());

            $command = new RegisterUserCommand(
                $data['login'],
                $data['lastname'],
                $data['firstname'],
                $data['mail'],
                $data['password'],
                $data['isActive'] ?? true,
                $groupIds,
                $profileIds,
                []
            );

            $this->bus->dispatch($command);

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(string $id, Request $request): Response
    {
        $user = $this->userRepository->findById(UserId::fromString($id));
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $formData = [
            'login' => $user->getLogin(),
            'lastname' => $user->getLastname(),
            'firstname' => $user->getFirstname(),
            'mail' => $user->getMail(),
            'isActive' => $user->isActive(),
            'groups' => $user->getGroups(),
            'profiles' => $user->getProfiles(),
        ];

        $form = $this->createForm(UserType::class, $formData, ['is_new' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $groupIds = array_map(fn($g) => (string)$g->getId(), $data['groups']->toArray());
            $profileIds = array_map(fn($p) => (string)$p->getId(), $data['profiles']->toArray());

            $command = new UpdateUserCommand(
                $id,
                $data['login'],
                $data['lastname'],
                $data['firstname'],
                $data['mail'],
                $data['isActive'] ?? true,
                $groupIds,
                $profileIds,
                $data['password'] ?: null
            );

            $this->bus->dispatch($command);

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(string $id, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $command = new DeleteUserCommand($id);
            $this->bus->dispatch($command);
        }

        return $this->redirectToRoute('admin_user_index');
    }
}
