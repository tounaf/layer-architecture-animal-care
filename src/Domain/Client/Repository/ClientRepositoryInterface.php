<?php

namespace Domain\Client\Repository;

use Domain\Client\Entity\Client;
use Domain\Shared\ValueObject\ClientId;

interface ClientRepositoryInterface
{
    public function save(Client $client): void;
    public function findById(ClientId $id): ?Client;
}
