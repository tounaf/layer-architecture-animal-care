<?php

namespace Application\User\Handler;

use Application\User\Command\UpdateUserCommand;
use Domain\User\Repository\UserRepositoryInterface;
use Domain\User\Repository\GroupRepositoryInterface;
use Domain\User\Repository\ProfileRepositoryInterface;
use Domain\User\Repository\RightRepositoryInterface;
use Domain\User\ValueObject\UserId;
use Domain\User\ValueObject\GroupId;
use Domain\User\ValueObject\ProfileId;
use Domain\User\ValueObject\RightId;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Infrastructure\Security\SecurityUser;

final class UpdateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private GroupRepositoryInterface $groupRepository,
        private ProfileRepositoryInterface $profileRepository,
        private RightRepositoryInterface $rightRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function __invoke(UpdateUserCommand $command): void
    {
        $user = $this->userRepository->findById(UserId::fromString($command->id));
        if (!$user) {
            throw new \RuntimeException('User not found');
        }

        $user->updateInformation(
            $command->login,
            $command->lastname,
            $command->firstname,
            $command->mail,
            $command->isActive
        );

        if ($command->password) {
            $securityUser = new SecurityUser($user);
            $hashedPassword = $this->passwordHasher->hashPassword($securityUser, $command->password);
            $user->updatePassword($hashedPassword);
        }

        $user->clearGroups();
        foreach ($command->groups as $groupId) {
            $group = $this->groupRepository->findById(GroupId::fromString($groupId));
            if ($group) {
                $user->addGroup($group);
            }
        }

        $user->clearProfiles();
        foreach ($command->profiles as $profileId) {
            $profile = $this->profileRepository->findById(ProfileId::fromString($profileId));
            if ($profile) {
                $user->addProfile($profile);
            }
        }

        $user->clearRights();
        foreach ($command->rights as $rightId) {
            $right = $this->rightRepository->findById(RightId::fromString($rightId));
            if ($right) {
                $user->addRight($right);
            }
        }

        $this->userRepository->save($user);
    }
}
