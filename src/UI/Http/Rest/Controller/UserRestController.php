<?php

namespace UI\Http\Rest\Controller;

use Application\User\Command\RegisterUserCommand;
use Application\User\Handler\RegisterUserHandler;
use Domain\User\Repository\RightRepositoryInterface;
use Domain\User\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users', name: 'api_users_')]
final class UserRestController extends AbstractController
{
    #[Route('', name: 'create', methods: ['POST'])]
    public function create(
        Request $request,
        RegisterUserHandler $handler,
        UserRepositoryInterface $userRepository,
        RightRepositoryInterface $rightRepository
    ): JsonResponse {
        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Payload JSON invalide.',
            ], Response::HTTP_BAD_REQUEST);
        }

        $requiredFields = ['login', 'lastname', 'firstname', 'mail', 'password'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || '' === trim((string) $data[$field])) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => sprintf('Le champ "%s" est obligatoire.', $field),
                ], Response::HTTP_BAD_REQUEST);
            }
        }

        if ($userRepository->findByLogin((string) $data['login'])) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Ce login existe deja.',
            ], Response::HTTP_CONFLICT);
        }

        if ($userRepository->findByMail((string) $data['mail'])) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Cet email existe deja.',
            ], Response::HTTP_CONFLICT);
        }

        $rightIds = is_array($data['right_ids'] ?? null) ? $data['right_ids'] : [];
        if (is_array($data['right_codes'] ?? null)) {
            foreach ($data['right_codes'] as $rightCode) {
                $right = $rightRepository->findByCode((string) $rightCode);
                if (!$right) {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => sprintf('Droit introuvable pour le code "%s".', $rightCode),
                    ], Response::HTTP_BAD_REQUEST);
                }
                $rightIds[] = (string) $right->getId();
            }
        }
        $rightIds = array_values(array_unique($rightIds));

        $command = new RegisterUserCommand(
            login: (string) $data['login'],
            lastname: (string) $data['lastname'],
            firstname: (string) $data['firstname'],
            mail: (string) $data['mail'],
            password: (string) $data['password'],
            isActive: (bool) ($data['is_active'] ?? true),
            groupIds: is_array($data['group_ids'] ?? null) ? $data['group_ids'] : [],
            profileIds: is_array($data['profile_ids'] ?? null) ? $data['profile_ids'] : [],
            rightIds: $rightIds
        );

        try {
            $handler($command);
            return new JsonResponse([
                'status' => 'success',
                'message' => 'Utilisateur cree avec succes.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
