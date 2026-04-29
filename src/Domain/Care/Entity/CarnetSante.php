<?php

namespace Domain\Care\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Shared\Entity\AggregateRoot;
use Domain\Care\ValueObject\CarnetSanteId;
use Domain\Shared\ValueObject\AnimalId;
use Domain\Care\Event\EntreeAjoutee;
use Domain\Care\ValueObject\EntreeCarnetId;
use Domain\Care\Enum\TypeEntree;
use Domain\Shared\ValueObject\PrestataireId;

class CarnetSante extends AggregateRoot
{
    /** @var Collection<int, EntreeCarnet> */
    private Collection $entrees;
    private \DateTimeImmutable $dateCreation;
    private \DateTimeImmutable $dateDerniereMiseAJour;

    public function __construct(
        private CarnetSanteId $id,
        private AnimalId $animalId,
        private string $informationsGenerales = '',
        private string $metadonnees = '',
        ?\DateTimeImmutable $dateCreation = null
    ) {
        $this->entrees = new ArrayCollection();
        $this->dateCreation = $dateCreation ?? new \DateTimeImmutable();
        $this->dateDerniereMiseAJour = new \DateTimeImmutable();
    }

    public static function creer(
        AnimalId $animalId,
        string $informationsGenerales = '',
        string $metadonnees = '',
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
        string $donneesStructurees = ''
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
    public function getEntrees(): Collection { return $this->entrees; }
    public function getDateCreation(): \DateTimeImmutable { return $this->dateCreation; }
    public function getInformationsGenerales(): string { return $this->informationsGenerales; }
    public function getMetadonnees(): string { return $this->metadonnees; }
    public function getDateDerniereMiseAJour(): \DateTimeImmutable { return $this->dateDerniereMiseAJour; }

    public function mettreAJourInformations(string $info, string $meta = ''): void
    {
        $this->informationsGenerales = $info;
        $this->metadonnees = $meta;
        $this->dateDerniereMiseAJour = new \DateTimeImmutable();
    }
}
