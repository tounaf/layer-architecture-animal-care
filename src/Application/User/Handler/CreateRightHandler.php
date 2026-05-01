<?php

namespace Application\User\Handler;

use Application\User\Command\CreateRightCommand;
use Domain\User\Entity\Right;
use Domain\User\Repository\RightRepositoryInterface;

final class CreateRightHandler
{
    public function __construct(private RightRepositoryInterface $rightRepository) {}

    public function __invoke(CreateRightCommand $command): void
    {
        $right = Right::create($command->rightName, $command->rightCode);
        $this->rightRepository->save($right);
    }
}
