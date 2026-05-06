<?php

namespace Infrastructure\Shared\Security;

use Domain\User\Repository\RightRepositoryInterface;
use Domain\User\Repository\UserRepositoryInterface;
use Domain\User\ValueObject\UserId;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final readonly class AccessControlSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
        private RightRepositoryInterface $rightRepository,
        private UserRepositoryInterface $userRepository,
        private CacheInterface $appCache
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();
        $routeName = $request->attributes->get('_route');

        if (!$routeName || str_starts_with($routeName, '_')) {
            return;
        }

        // Vérifier si la route nécessite un droit spécifique
        // On considère ici que si un droit existe avec le code correspondant à la route, il doit être vérifié
        $right = $this->rightRepository->findByCode($routeName);
        if (!$right) {
            return;
        }

        $user = $this->security->getUser();
        if (!$user) {
            throw new AccessDeniedHttpException('Utilisateur non connecté.');
        }

        // L'identifiant de l'utilisateur (UserId en string)
        $userId = $user->getUserIdentifier();

        $hasAccess = $this->appCache->get("user_access_{$userId}_{$routeName}", function (ItemInterface $item) use ($userId, $routeName) {
            $item->expiresAfter(3600); // 1 heure de cache

            $domainUser = $this->userRepository->findById(UserId::fromString($userId));
            if (!$domainUser) {
                return false;
            }

            // Récupérer tous les codes de droits de l'utilisateur
            $userRightCodes = $this->getAllUserRightCodes($domainUser);

            return in_array($routeName, $userRightCodes, true);
        });

        if (!$hasAccess) {
            throw new AccessDeniedHttpException("Vous n'avez pas le droit d'accéder à cette ressource ({$routeName}).");
        }
    }

    private function getAllUserRightCodes($user): array
    {
        $codes = [];
        // Droits directs
        foreach ($user->getRights() as $right) {
            $codes[] = $right->getRightCode();
        }

        // Profils directs
        foreach ($user->getProfiles() as $profile) {
            foreach ($profile->getRights() as $right) {
                $codes[] = $right->getRightCode();
            }
        }

        // Groupes
        foreach ($user->getGroups() as $group) {
            foreach ($group->getRights() as $right) {
                $codes[] = $right->getRightCode();
            }
            foreach ($group->getProfiles() as $profile) {
                foreach ($profile->getRights() as $right) {
                    $codes[] = $right->getRightCode();
                }
            }
        }

        return array_unique($codes);
    }
}
