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
        private array $metadonnees = [],
        ?\DateTimeImmutable $dateCreation = null
    ) {
        $this->dateCreation = $dateCreation ?? new \DateTimeImmutable();
        $this->dateDerniereMiseAJour = new \DateTimeImmutable();
    }

    public static function creer(
        AnimalId $animalId,
        string $informationsGenerales = '',
        array $metadonnees = [],
        ?\DateTimeImmutable $dateCreation = null
    ): self {
        return new self(CarnetSanteId::generate(), $animalId, $informationsGenerales, $metadonnees, $dateCreation);
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

    public function getId(): CarnetSanteId { return $this->id; }
    public function getAnimalId(): AnimalId { return $this->animalId; }
    public function getEntrees(): array { return $this->entrees; }
    public function getDateCreation(): \DateTimeImmutable { return $this->dateCreation; }
    public function getInformationsGenerales(): string { return $this->informationsGenerales; }
    public function getMetadonnees(): array { return $this->metadonnees; }
    public function getDateDerniereMiseAJour(): \DateTimeImmutable { return $this->dateDerniereMiseAJour; }

    public function mettreAJourInformations(string $info, array $meta = []): void
    {
        $this->informationsGenerales = $info;
        $this->metadonnees = array_merge($this->metadonnees, $meta);
        $this->dateDerniereMiseAJour = new \DateTimeImmutable();
    }
}
