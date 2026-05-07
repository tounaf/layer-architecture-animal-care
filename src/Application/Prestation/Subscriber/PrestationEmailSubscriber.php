<?php

namespace Application\Prestation\Subscriber;

use Domain\Prestation\Event\PrestationRealisee;
use Domain\Prestation\Repository\PrestationRepositoryInterface;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\Client\Repository\ClientRepositoryInterface;
use Infrastructure\Shared\Email\EmailSender;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class PrestationEmailSubscriber
{
    public function __construct(
        private PrestationRepositoryInterface $prestationRepository,
        private RendezVousRepositoryInterface $rendezVousRepository,
        private ClientRepositoryInterface $clientRepository,
        private EmailSender $emailSender
    ) {}

    #[AsMessageHandler]
    public function onPrestationRealisee(PrestationRealisee $event): void
    {
        $prestation = $this->prestationRepository->findById($event->prestationId);
        if (!$prestation) return;

        $rdv = $this->rendezVousRepository->findById($prestation->getRendezVousId());
        if (!$rdv) return;

        $client = $this->clientRepository->findById($rdv->getClientId());
        if (!$client) return;

        $this->emailSender->sendTemplatedEmail(
            $client->getEmail(),
            'Résumé de votre prestation',
            'emails/prestation_resume_client.html.twig',
            ['prestation' => $prestation, 'client' => $client, 'rdv' => $rdv]
        );
    }
}
