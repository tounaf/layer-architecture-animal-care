<?php

namespace App\Tests\Unit\Domain\RendezVous;

use Domain\RendezVous\Entity\RendezVous;
use Domain\RendezVous\Enum\StatutRendezVous;
use Domain\RendezVous\ValueObject\RendezVousId;
use Domain\Shared\ValueObject\ClientId;
use Domain\Shared\ValueObject\AnimalId;
use Domain\Shared\ValueObject\PrestataireId;
use Domain\Prestataire\ValueObject\ServiceProposeId;
use PHPUnit\Framework\TestCase;

class RendezVousTest extends TestCase
{
    public function testReporterRendezVous(): void
    {
        $rdv = RendezVous::creer(
            ClientId::generate(),
            AnimalId::generate(),
            PrestataireId::generate(),
            ServiceProposeId::generate(),
            new \DateTimeImmutable('2026-05-01'),
            '10:00',
            30
        );

        $this->assertEquals(StatutRendezVous::EN_ATTENTE, $rdv->getStatut());
        $this->assertEquals('10:00', $rdv->getPlageHoraire()->getDebut());

        $nouvelleDate = new \DateTimeImmutable('2026-05-02');
        $nouvelleHeure = '14:00';

        $rdv->reporter($nouvelleDate, $nouvelleHeure);

        $this->assertEquals($nouvelleDate, $rdv->getDateRdv());
        $this->assertEquals('14:00', $rdv->getPlageHoraire()->getDebut());
        // La durée doit rester la même (30 min)
        $this->assertEquals(30, $rdv->getPlageHoraire()->getDuree());
    }

    public function testAnnulerRendezVous(): void
    {
        $rdv = RendezVous::creer(
            ClientId::generate(),
            AnimalId::generate(),
            PrestataireId::generate(),
            ServiceProposeId::generate(),
            new \DateTimeImmutable('2026-05-01'),
            '10:00',
            30
        );

        $rdv->annuler('Client indisponible');

        $this->assertEquals(StatutRendezVous::ANNULE, $rdv->getStatut());
        
        $events = $rdv->getEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(\Domain\RendezVous\Event\RendezVousAnnule::class, $events[0]);
    }

    public function testConfirmerRendezVous(): void
    {
        $rdv = RendezVous::creer(
            ClientId::generate(),
            AnimalId::generate(),
            PrestataireId::generate(),
            ServiceProposeId::generate(),
            new \DateTimeImmutable('2026-05-01'),
            '10:00',
            30
        );

        $rdv->confirmer();

        $this->assertEquals(StatutRendezVous::CONFIRME, $rdv->getStatut());
    }
}
