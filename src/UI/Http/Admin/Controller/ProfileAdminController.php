<?php

namespace UI\Http\Admin\Controller;

use Application\User\Command\CreateProfileCommand;
use Application\User\Command\UpdateProfileCommand;
use Application\User\Command\DeleteProfileCommand;
use Domain\User\Repository\ProfileRepositoryInterface;
use Domain\User\ValueObject\ProfileId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use UI\Http\Admin\Form\ProfileType;

#[Route('/admin/profile', name: 'admin_profile_')]
class ProfileAdminController extends AbstractController
{
    public function __construct(
        private ProfileRepositoryInterface $profileRepository,
        private MessageBusInterface $bus
    ) {}

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/profile/index.html.twig', [
            'profiles' => $this->profileRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request): Response
    {
        $form = $this->createForm(ProfileType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $rightIds = array_map(fn($r) => (string)$r->getId(), $data['rights']->toArray());

            $this->bus->dispatch(new CreateProfileCommand($data['profileName'], $rightIds));
            return $this->redirectToRoute('admin_profile_index');
        }

        return $this->render('admin/profile/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(string $id, Request $request): Response
    {
        $profile = $this->profileRepository->findById(ProfileId::fromString($id));
        if (!$profile) throw $this->createNotFoundException();

        $form = $this->createForm(ProfileType::class, [
            'profileName' => $profile->getProfileName(),
            'rights' => $profile->getRights()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $rightIds = array_map(fn($r) => (string)$r->getId(), $data['rights']->toArray());

            $this->bus->dispatch(new UpdateProfileCommand($id, $data['profileName'], $rightIds));
            return $this->redirectToRoute('admin_profile_index');
        }

        return $this->render('admin/profile/edit.html.twig', ['form' => $form->createView(), 'profile' => $profile]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(string $id): Response
    {
        $profile = $this->profileRepository->findById(ProfileId::fromString($id));
        if (!$profile) throw $this->createNotFoundException();
        return $this->render('admin/profile/show.html.twig', ['profile' => $profile]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(string $id, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $this->bus->dispatch(new DeleteProfileCommand($id));
        }
        return $this->redirectToRoute('admin_profile_index');
    }
}
