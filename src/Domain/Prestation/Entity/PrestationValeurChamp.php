<?php

namespace Domain\Prestation\Entity;

use Domain\Prestation\ValueObject\PrestationId;
use Domain\Service\ValueObject\ServiceChampId;
use Domain\Document\ValueObject\DocumentId;

class PrestationValeurChamp
{
    public function __construct(
        private PrestationId $prestationId,
        private ServiceChampId $serviceChampId,
        private ?string $valeur = null,
        private string $typeValeur = 'texte',
        private ?DocumentId $documentId = null
    ) {
    }

    public function getPrestationId(): PrestationId { return $this->prestationId; }
    public function getServiceChampId(): ServiceChampId { return $this->serviceChampId; }
    public function getValeur(): ?string { return $this->valeur; }
    public function getTypeValeur(): string { return $this->typeValeur; }
    public function getDocumentId(): ?DocumentId { return $this->documentId; }
}
