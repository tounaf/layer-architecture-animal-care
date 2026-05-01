<?php

namespace Application\User\Handler;

use Application\User\Command\UpdateProfileCommand;
use Domain\User\Repository\ProfileRepositoryInterface;
use Domain\User\Repository\RightRepositoryInterface;
use Domain\User\ValueObject\ProfileId;
use Domain\User\ValueObject\RightId;

final class UpdateProfileHandler
{
    public function __construct(
        private ProfileRepositoryInterface $profileRepository,
        private RightRepositoryInterface $rightRepository
    ) {}

    public function __invoke(UpdateProfileCommand $command): void
    {
        $profile = $this->profileRepository->findById(ProfileId::fromString($command->id));
        if (!$profile) throw new \RuntimeException('Profile not found');

        $profile->updateInformation($command->profileName);

        $profile->clearRights();
        foreach ($command->rightIds as $rightId) {
            $right = $this->rightRepository->findById(RightId::fromString($rightId));
            if ($right) $profile->addRight($right);
        }

        $this->profileRepository->save($profile);
    }
}
