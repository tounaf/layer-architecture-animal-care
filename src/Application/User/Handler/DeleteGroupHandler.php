<?php

namespace Application\User\Handler;

use Application\User\Command\DeleteGroupCommand;
use Domain\User\Repository\GroupRepositoryInterface;
use Domain\User\ValueObject\GroupId;

final class DeleteGroupHandler
{
    public function __construct(private GroupRepositoryInterface $groupRepository) {}

    public function __invoke(DeleteGroupCommand $command): void
    {
        $group = $this->groupRepository->findById(GroupId::fromString($command->id));
        if ($group) $this->groupRepository->delete($group);
    }
}
