<?php

namespace Application\User\Handler;

use Application\User\Command\CreateGroupCommand;
use Domain\User\Entity\Group;
use Domain\User\Repository\GroupRepositoryInterface;
use Domain\User\Repository\RightRepositoryInterface;
use Domain\User\Repository\ProfileRepositoryInterface;
use Domain\User\ValueObject\RightId;
use Domain\User\ValueObject\ProfileId;

final class CreateGroupHandler
{
    public function __construct(
        private GroupRepositoryInterface $groupRepository,
        private RightRepositoryInterface $rightRepository,
        private ProfileRepositoryInterface $profileRepository
    ) {}

    public function __invoke(CreateGroupCommand $command): void
    {
        $group = Group::create($command->groupName);

        foreach ($command->rightIds as $rightId) {
            $right = $this->rightRepository->findById(RightId::fromString($rightId));
            if ($right) $group->addRight($right);
        }

        foreach ($command->profileIds as $profileId) {
            $profile = $this->profileRepository->findById(ProfileId::fromString($profileId));
            if ($profile) $group->addProfile($profile);
        }

        $this->groupRepository->save($group);
    }
}
