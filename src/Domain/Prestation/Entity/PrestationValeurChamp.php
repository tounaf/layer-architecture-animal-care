<?php

namespace Domain\Prestation\Entity;

use Domain\Service\ValueObject\ServiceChampId;
use Domain\Document\ValueObject\DocumentId;
use Domain\Prestation\ValueObject\PrestationId;

class PrestationValeurChamp
{
    public function __construct(
        private Prestation $prestation,
        private ServiceChampId $serviceChampId,
        private ?string $valeur = null,
        private string $typeValeur = 'texte',
        private ?DocumentId $documentId = null
    ) {
    }

    public function getPrestation(): Prestation { return $this->prestation; }
    public function getPrestationId(): PrestationId { return $this->prestation->getId(); }
    public function getServiceChampId(): ServiceChampId { return $this->serviceChampId; }
    public function getValeur(): ?string { return $this->valeur; }
    public function getTypeValeur(): string { return $this->typeValeur; }
    public function getDocumentId(): ?DocumentId { return $this->documentId; }
}
