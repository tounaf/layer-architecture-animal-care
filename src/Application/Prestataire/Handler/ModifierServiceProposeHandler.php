<?php

namespace Application\Prestataire\Handler;

use Application\Prestataire\Command\ModifierServiceProposeCommand;
use Domain\Prestataire\Repository\ServiceProposeRepositoryInterface;
use Domain\Prestataire\ValueObject\ServiceProposeId;
use Domain\Service\ValueObject\ServiceId;

final class ModifierServiceProposeHandler
{
    public function __construct(
        private ServiceProposeRepositoryInterface $repository
    ) {
    }

    public function __invoke(ModifierServiceProposeCommand $command): void
    {
        $servicePropose = $this->repository->findById(ServiceProposeId::fromString($command->id));

        if (!$servicePropose) {
            throw new \InvalidArgumentException('Service proposé non trouvé');
        }

        $servicePropose->modifier(
            ServiceId::fromString($command->serviceId),
            $command->actif,
            $command->description
        );

        $this->repository->save($servicePropose);
    }
}
