<?php
// src/Domain/RendezVous/Repository/RendezVousRepositoryInterface.php
namespace Domain\RendezVous\Repository;

use Domain\RendezVous\Entity\RendezVous;

interface RendezVousRepositoryInterface
{
    public function getById(string $id): ?RendezVous;
    public function save(RendezVous $rendezVous): void;
}
