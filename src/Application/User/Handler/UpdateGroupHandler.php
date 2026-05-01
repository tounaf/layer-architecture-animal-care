<?php

namespace Application\User\Handler;

use Application\User\Command\UpdateGroupCommand;
use Domain\User\Repository\GroupRepositoryInterface;
use Domain\User\Repository\RightRepositoryInterface;
use Domain\User\Repository\ProfileRepositoryInterface;
use Domain\User\ValueObject\GroupId;
use Domain\User\ValueObject\RightId;
use Domain\User\ValueObject\ProfileId;

final class UpdateGroupHandler
{
    public function __construct(
        private GroupRepositoryInterface $groupRepository,
        private RightRepositoryInterface $rightRepository,
        private ProfileRepositoryInterface $profileRepository
    ) {}

    public function __invoke(UpdateGroupCommand $command): void
    {
        $group = $this->groupRepository->findById(GroupId::fromString($command->id));
        if (!$group) throw new \RuntimeException('Group not found');

        $group->updateInformation($command->groupName);

        $group->clearRights();
        foreach ($command->rightIds as $rightId) {
            $right = $this->rightRepository->findById(RightId::fromString($rightId));
            if ($right) $group->addRight($right);
        }

        $group->clearProfiles();
        foreach ($command->profileIds as $profileId) {
            $profile = $this->profileRepository->findById(ProfileId::fromString($profileId));
            if ($profile) $group->addProfile($profile);
        }

        $this->groupRepository->save($group);
    }
}
