<?php

namespace Application\User\Handler;

use Application\User\Command\UpdateRightCommand;
use Domain\User\Repository\RightRepositoryInterface;
use Domain\User\ValueObject\RightId;

final class UpdateRightHandler
{
    public function __construct(private RightRepositoryInterface $rightRepository) {}

    public function __invoke(UpdateRightCommand $command): void
    {
        $right = $this->rightRepository->findById(RightId::fromString($command->id));
        if (!$right) throw new \RuntimeException('Right not found');

        $right->updateInformation($command->rightName, $command->rightCode);
        $this->rightRepository->save($right);
    }
}
