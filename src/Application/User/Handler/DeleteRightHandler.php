<?php

namespace Application\User\Handler;

use Application\User\Command\DeleteRightCommand;
use Domain\User\Repository\RightRepositoryInterface;
use Domain\User\ValueObject\RightId;

final class DeleteRightHandler
{
    public function __construct(private RightRepositoryInterface $rightRepository) {}

    public function __invoke(DeleteRightCommand $command): void
    {
        $right = $this->rightRepository->findById(RightId::fromString($command->id));
        if ($right) $this->rightRepository->delete($right);
    }
}
