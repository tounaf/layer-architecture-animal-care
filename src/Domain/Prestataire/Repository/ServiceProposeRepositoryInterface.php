<?php

namespace Domain\Prestataire\Repository;

use Domain\Prestataire\Entity\ServicePropose;
use Domain\Prestataire\ValueObject\ServiceProposeId;
use Domain\Shared\ValueObject\PrestataireId;

interface ServiceProposeRepositoryInterface
{
    public function save(ServicePropose $servicePropose): void;
    public function findById(ServiceProposeId $id): ?ServicePropose;
    /** @return ServicePropose[] */
    public function findByPrestataire(PrestataireId $prestataireId): array;
    public function delete(ServicePropose $servicePropose): void;
}
