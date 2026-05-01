<?php

namespace Application\User\Handler;

use Application\User\Command\RegisterUserCommand;
use Domain\User\Entity\User;
use Domain\User\Repository\UserRepositoryInterface;
use Domain\User\Repository\GroupRepositoryInterface;
use Domain\User\Repository\ProfileRepositoryInterface;
use Domain\User\Repository\RightRepositoryInterface;
use Domain\User\ValueObject\GroupId;
use Domain\User\ValueObject\ProfileId;
use Domain\User\ValueObject\RightId;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Infrastructure\Security\SecurityUser;

final class RegisterUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private GroupRepositoryInterface $groupRepository,
        private ProfileRepositoryInterface $profileRepository,
        private RightRepositoryInterface $rightRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        // En un premier temps, on crée l'utilisateur sans le mot de passe hashé pour pouvoir utiliser le passwordHasher
        $user = User::create(
            $command->login,
            $command->lastname,
            $command->firstname,
            $command->mail,
            '' // Password temporaire
        );

        // On hashe le mot de passe
        // Le PasswordHasher de Symfony attend un UserInterface
        $securityUser = new SecurityUser($user);
        $hashedPassword = $this->passwordHasher->hashPassword($securityUser, $command->password);

        // On recrée l'utilisateur avec le bon mot de passe (ou on ajoute un setter de password dans l'entité User)
        // Pour rester "Rich Domain Model", on pourrait avoir une méthode $user->updatePassword($hashedPassword)
        // Mais ici on va tricher un peu pour l'exemple ou rajouter la méthode.

        $user->updatePassword($hashedPassword);

        foreach ($command->groupIds as $groupId) {
            $group = $this->groupRepository->findById(GroupId::fromString($groupId));
            if ($group) {
                $user->addGroup($group);
            }
        }

        foreach ($command->profileIds as $profileId) {
            $profile = $this->profileRepository->findById(ProfileId::fromString($profileId));
            if ($profile) {
                $user->addProfile($profile);
            }
        }

        foreach ($command->rightIds as $rightId) {
            $right = $this->rightRepository->findById(RightId::fromString($rightId));
            if ($right) {
                $user->addRight($right);
            }
        }

        $this->userRepository->save($user);
    }
}
