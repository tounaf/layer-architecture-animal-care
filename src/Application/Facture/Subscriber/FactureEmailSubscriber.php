<?php

namespace Application\Facture\Subscriber;

use Domain\Facture\Event\FactureGeneree;
use Domain\Facture\Repository\FactureRepositoryInterface;
use Domain\Prestation\Repository\PrestationRepositoryInterface;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\Client\Repository\ClientRepositoryInterface;
use Infrastructure\Shared\Email\EmailSender;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class FactureEmailSubscriber
{
    public function __construct(
        private FactureRepositoryInterface $factureRepository,
        private PrestationRepositoryInterface $prestationRepository,
        private RendezVousRepositoryInterface $rendezVousRepository,
        private ClientRepositoryInterface $clientRepository,
        private EmailSender $emailSender
    ) {}

    #[AsMessageHandler]
    public function onFactureGeneree(FactureGeneree $event): void
    {
        $facture = $this->factureRepository->findById($event->factureId);
        if (!$facture) return;

        $prestation = $this->prestationRepository->findById($facture->getPrestationId());
        if (!$prestation) return;

        $rdv = $this->rendezVousRepository->findById($prestation->getRendezVousId());
        if (!$rdv) return;

        $client = $this->clientRepository->findById($rdv->getClientId());
        if (!$client) return;

        $this->emailSender->sendTemplatedEmail(
            $client->getEmail(),
            'Votre facture ' . $facture->getNumeroFacture(),
            'emails/facture_client.html.twig',
            ['facture' => $facture, 'client' => $client, 'prestation' => $prestation]
        );
    }
}
