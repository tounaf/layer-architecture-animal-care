<?php

namespace Infrastructure\Persistence\Doctrine\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Domain\RendezVous\Entity\RendezVous;
use Domain\Shared\ValueObject\ClientId;
use Domain\Shared\ValueObject\AnimalId;
use Domain\Shared\ValueObject\PrestataireId;
use Domain\Prestataire\Entity\Prestataire;
use Domain\Prestataire\Entity\ServicePropose;
use Domain\Client\Entity\Client;
use Domain\Animal\Entity\Animal;

class RendezVousFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // On récupère les données via les repositories car les IDs sont générés
        $clients = $manager->getRepository(Client::class)->findAll();
        $animals = $manager->getRepository(Animal::class)->findAll();
        $prestataires = $manager->getRepository(Prestataire::class)->findAll();
        $proposes = $manager->getRepository(ServicePropose::class)->findAll();

        $clientsByNom = []; foreach($clients as $c) $clientsByNom[$c->getNom()] = $c;
        $animalsByNom = []; foreach($animals as $a) $animalsByNom[$a->getNom()] = $a;
        $prestatairesByNom = []; foreach($prestataires as $p) $prestatairesByNom[$p->getNomStructure()] = $p;

        // On a besoin de mapper les services proposés par prestataire et code service
        // Mais pour la fixture simple, on va matcher par index ou description si possible
        // Données utilisateur :
        // 1 | Client 1 (Hery) | Animal 1 (Médor) | Prestataire 1 (Analakely) | Propose 1 (CONS_RDV) | 23/02/2026 | 09:00 | 30min | confirme
        // 2 | Client 2 (Miora) | Animal 3 (Loulou) | Prestataire 2 (Isotry) | Propose 5 (TOIL_SIMPLE) | 23/02/2026 | 14:00 | 90min | confirme
        // 3 | Client 3 (Faly) | Animal 4 (Coco) | Prestataire 3 (Rasoa) | Propose 8 (CONS_DOM) | 24/02/2026 | 10:00 | 45min | en_attente
        // 4 | Client 1 (Hery) | Animal 2 (Kitty) | Prestataire 3 (Rasoa) | Propose 10 (CONS_NUIT) | 24/02/2026 | 20:00 | 30min | confirme
        // 5 | Client 1 (Hery) | Animal 1 (Médor) | Prestataire 4 (Doggy) | Propose 14 (PENS_COURT) | 01/03/2026 | 08:00 | 540min | en_attente

        $rdvData = [
            ['Rakotondrazaka', 'Médor', 'Clinique Vétérinaire Analakely', 'Consultations du lundi au vendredi', '23/02/2026', '09:00', 30, 'confirme'],
            ['Randrianarison', 'Loulou', 'Toilettage Canin Isotry', 'Toilettage simple avec produits naturels', '23/02/2026', '14:00', 90, 'confirme'],
            ['Rajoelina', 'Coco', 'Dr. Rasoa - Vétérinaire à domicile', 'Visites à domicile sur tout Tana', '24/02/2026', '10:00', 45, 'en_attente'],
            ['Rakotondrazaka', 'Kitty', 'Dr. Rasoa - Vétérinaire à domicile', 'Consultations de nuit (après 19h)', '24/02/2026', '20:00', 30, 'confirme'],
            ['Rakotondrazaka', 'Médor', 'Pension Doggy Palace', 'Séjour court (0-5 jours)', '01/03/2026', '08:00', 540, 'en_attente'],
        ];

        foreach ($rdvData as $data) {
            $client = $clientsByNom[$data[0]] ?? null;
            $animal = $animalsByNom[$data[1]] ?? null;
            $prestataire = $prestatairesByNom[$data[2]] ?? null;

            // Recherche du service proposé par description pour être précis
            $servicePropose = null;
            foreach ($proposes as $p) {
                if ($p->getPrestataireId()->equals($prestataire->getId()) && $p->getDescription() === $data[3]) {
                    $servicePropose = $p;
                    break;
                }
            }

            if ($client && $animal && $prestataire && $servicePropose) {
                $rdv = RendezVous::creer(
                    $client->getId(),
                    $animal->getId(),
                    $prestataire->getId(),
                    $servicePropose->getId(),
                    \DateTimeImmutable::createFromFormat('d/m/Y', $data[4]),
                    $data[5],
                    $data[6]
                );

                if ($data[7] === 'confirme') {
                    $rdv->confirmer();
                }

                $manager->persist($rdv);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ClientAnimalFixtures::class,
            PrestataireFixtures::class,
        ];
    }
}
