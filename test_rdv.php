<?php

require_once 'vendor/autoload.php';

use Domain\RendezVous\Entity\RendezVous;
use Domain\RendezVous\Enum\StatutRendezVous;
use Domain\Shared\ValueObject\ClientId;
use Domain\Shared\ValueObject\AnimalId;
use Domain\Shared\ValueObject\PrestataireId;
use Domain\Prestataire\ValueObject\ServiceProposeId;

try {
    $rdv = RendezVous::creer(
        ClientId::generate(),
        AnimalId::generate(),
        PrestataireId::generate(),
        ServiceProposeId::generate(),
        new \DateTimeImmutable('2026-05-01'),
        '10:00',
        30
    );

    echo "Initial status: " . $rdv->getStatut()->value . "\n";

    $rdv->confirmer();
    echo "Status after confirm: " . $rdv->getStatut()->value . "\n";

    $rdv->reporter(new \DateTimeImmutable('2026-05-02'), '14:00');
    echo "Status after reschedule: " . $rdv->getStatut()->value . "\n";
    echo "New date: " . $rdv->getDateRdv()->format('Y-m-d') . "\n";
    echo "New time: " . $rdv->getPlageHoraire()->getDebut() . "\n";

    $rdv->annuler('Test cancellation');
    echo "Status after cancel: " . $rdv->getStatut()->value . "\n";

    echo "TEST SUCCESSFUL\n";
} catch (\Exception $e) {
    echo "TEST FAILED: " . $e->getMessage() . "\n";
    exit(1);
}
