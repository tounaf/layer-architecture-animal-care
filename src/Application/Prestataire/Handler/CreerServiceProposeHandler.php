<?php

namespace Application\Prestataire\Handler;

use Application\Prestataire\Command\CreerServiceProposeCommand;
use Domain\Prestataire\Entity\ServicePropose;
use Domain\Prestataire\Repository\ServiceProposeRepositoryInterface;
use Domain\Shared\ValueObject\PrestataireId;
use Domain\Service\ValueObject\ServiceId;

final class CreerServiceProposeHandler
{
    public function __construct(
        private ServiceProposeRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreerServiceProposeCommand $command): void
    {
        $servicePropose = ServicePropose::creer(
            PrestataireId::fromString($command->prestataireId),
            ServiceId::fromString($command->serviceId),
            $command->actif,
            $command->description
        );

        $this->repository->save($servicePropose);
    }
}
