<?php

namespace Application\RendezVous\Subscriber;

use Domain\RendezVous\Event\RendezVousDemande;
use Domain\RendezVous\Event\RendezVousConfirme;
use Domain\RendezVous\Event\RendezVousAnnule;
use Domain\RendezVous\Event\RendezVousReporte;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\Client\Repository\ClientRepositoryInterface;
use Domain\Prestataire\Repository\PrestataireRepositoryInterface;
use Infrastructure\Shared\Email\EmailSender;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class RendezVousEmailSubscriber
{
    public function __construct(
        private RendezVousRepositoryInterface $rendezVousRepository,
        private ClientRepositoryInterface $clientRepository,
        private PrestataireRepositoryInterface $prestataireRepository,
        private EmailSender $emailSender
    ) {}

    #[AsMessageHandler]
    public function onDemande(RendezVousDemande $event): void
    {
        $rdv = $this->rendezVousRepository->findById($event->rendezVousId);
        $client = $this->clientRepository->findById($event->clientId);
        $prestataire = $this->prestataireRepository->findById($event->prestataireId);

        if ($client) {
            $this->emailSender->sendTemplatedEmail(
                $client->getEmail(),
                'Votre demande de rendez-vous est en attente',
                'emails/rdv_demande_client.html.twig',
                ['rdv' => $rdv, 'client' => $client]
            );
        }

        if ($prestataire) {
            $this->emailSender->sendTemplatedEmail(
                $prestataire->getEmail(),
                'Nouvelle demande de rendez-vous',
                'emails/rdv_demande_prestataire.html.twig',
                ['rdv' => $rdv, 'prestataire' => $prestataire]
            );
        }
    }

    #[AsMessageHandler]
    public function onConfirme(RendezVousConfirme $event): void
    {
        $rdv = $this->rendezVousRepository->findById($event->getRendezVousId());
        $client = $this->clientRepository->findById($event->getClientId());
        $prestataire = $this->prestataireRepository->findById($event->getPrestataireId());

        if ($client) {
            $this->emailSender->sendTemplatedEmail(
                $client->getEmail(),
                'Votre rendez-vous est confirmé',
                'emails/rdv_confirme_client.html.twig',
                ['rdv' => $rdv, 'client' => $client]
            );
        }
    }

    #[AsMessageHandler]
    public function onAnnule(RendezVousAnnule $event): void
    {
        $rdv = $this->rendezVousRepository->findById($event->getRendezVousId());
        if (!$rdv) return;

        $client = $this->clientRepository->findById($rdv->getClientId());
        $prestataire = $this->prestataireRepository->findById($rdv->getPrestataireId());

        if ($client) {
            $this->emailSender->sendTemplatedEmail(
                $client->getEmail(),
                'Rendez-vous annulé',
                'emails/rdv_annule_client.html.twig',
                ['rdv' => $rdv, 'motif' => $event->getMotif()]
            );
        }

        if ($prestataire) {
            $this->emailSender->sendTemplatedEmail(
                $prestataire->getEmail(),
                'Rendez-vous annulé par le client',
                'emails/rdv_annule_prestataire.html.twig',
                ['rdv' => $rdv, 'motif' => $event->getMotif()]
            );
        }
    }

    #[AsMessageHandler]
    public function onReporte(RendezVousReporte $event): void
    {
        $rdv = $this->rendezVousRepository->findById($event->rendezVousId);
        if (!$rdv) return;

        $client = $this->clientRepository->findById($rdv->getClientId());

        if ($client) {
            $this->emailSender->sendTemplatedEmail(
                $client->getEmail(),
                'Votre rendez-vous a été reporté',
                'emails/rdv_reporte_client.html.twig',
                ['rdv' => $rdv]
            );
        }
    }
}
