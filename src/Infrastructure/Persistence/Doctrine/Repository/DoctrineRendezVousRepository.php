<?php
// src/Infrastructure/Persistence/Doctrine/Repository/DoctrineRendezVousRepository.php
namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\RendezVous\Entity\RendezVous;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;

final class DoctrineRendezVousRepository implements RendezVousRepositoryInterface
{
    public function getById(string $id): ?RendezVous
    {
        // Dummy implementation
        return new RendezVous($id);
    }

    public function save(RendezVous $rendezVous): void
    {
        // Dummy implementation (Doctrine persist/flush would go here)
    }
}
