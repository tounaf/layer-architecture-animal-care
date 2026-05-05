<?php

namespace Application\Facture\Handler;

use Domain\Prestation\Event\PrestationRealisee;
use Domain\Facture\Entity\Facture;
use Domain\Facture\Repository\FactureRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GenererFactureSurPrestationRealiseeHandler
{
    public function __construct(
        private FactureRepositoryInterface $factureRepository
    ) {}

    public function __invoke(PrestationRealisee $event): void
    {
        $facture = Facture::genererDepuisPrestation(
            $event->prestationId,
            $event->montantTotal
        );

        $this->factureRepository->save($facture);
    }
}
