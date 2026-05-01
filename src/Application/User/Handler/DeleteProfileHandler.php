<?php

namespace Application\User\Handler;

use Application\User\Command\DeleteProfileCommand;
use Domain\User\Repository\ProfileRepositoryInterface;
use Domain\User\ValueObject\ProfileId;

final class DeleteProfileHandler
{
    public function __construct(private ProfileRepositoryInterface $profileRepository) {}

    public function __invoke(DeleteProfileCommand $command): void
    {
        $profile = $this->profileRepository->findById(ProfileId::fromString($command->id));
        if ($profile) $this->profileRepository->delete($profile);
    }
}
