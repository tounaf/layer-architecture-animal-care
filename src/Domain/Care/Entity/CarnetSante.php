<?php

namespace Domain\Care\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Care\ValueObject\CarnetSanteId;
use Domain\Shared\ValueObject\AnimalId;
use Domain\Care\Event\EntreeAjoutee;
use Domain\Care\ValueObject\EntreeCarnetId;
use Domain\Care\Enum\TypeEntree;
use Domain\Shared\ValueObject\PrestataireId;

class CarnetSante extends AggregateRoot
{
    /** @var EntreeCarnet[] */
    private array $entrees = [];
    private \DateTimeImmutable $dateCreation;
    private \DateTimeImmutable $dateDerniereMiseAJour;

    public function __construct(
        private CarnetSanteId $id,
        private AnimalId $animalId,
        private string $informationsGenerales = '',
        private array $metadonnees = []
    ) {
        $this->dateCreation = new \DateTimeImmutable();
        $this->dateDerniereMiseAJour = new \DateTimeImmutable();
    }

    public static function creer(AnimalId $animalId): self
    {
        return new self(CarnetSanteId::generate(), $animalId);
    }

    public function ajouterEntree(
        TypeEntree $type,
        string $titre,
        string $description,
        PrestataireId $etabliPar,
        bool $visibleProprietaire = true,
        ?\DateTimeInterface $dateRappel = null,
        array $donneesStructurees = []
    ): void {
        $entreeId = EntreeCarnetId::generate();
        $entree = new EntreeCarnet(
            $entreeId,
            $type,
            $titre,
            $description,
            $etabliPar,
            $visibleProprietaire,
            $dateRappel,
            $donneesStructurees
        );
        $entree->setCarnetSante($this);

        $this->entrees[] = $entree;
        $this->dateDerniereMiseAJour = new \DateTimeImmutable();

        $this->recordEvent(new EntreeAjoutee(
            $this->id,
            $entreeId,
            $this->animalId,
            $type
        ));
    }

    public function getId(): CarnetSanteId
    {
        return $this->id;
    }

    public function getAnimalId(): AnimalId
    {
        return $this->animalId;
    }

    public function getEntrees(): array
    {
        return $this->entrees;
    }
}
