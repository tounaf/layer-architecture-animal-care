<?php

namespace Application\User\Handler;

use Application\User\Command\CreateProfileCommand;
use Domain\User\Entity\Profile;
use Domain\User\Repository\ProfileRepositoryInterface;
use Domain\User\Repository\RightRepositoryInterface;
use Domain\User\ValueObject\RightId;

final class CreateProfileHandler
{
    public function __construct(
        private ProfileRepositoryInterface $profileRepository,
        private RightRepositoryInterface $rightRepository
    ) {}

    public function __invoke(CreateProfileCommand $command): void
    {
        $profile = Profile::create($command->profileName);

        foreach ($command->rightIds as $rightId) {
            $right = $this->rightRepository->findById(RightId::fromString($rightId));
            if ($right) $profile->addRight($right);
        }

        $this->profileRepository->save($profile);
    }
}
