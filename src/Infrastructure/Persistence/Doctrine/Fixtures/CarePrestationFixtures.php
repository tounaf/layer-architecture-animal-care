<?php

namespace Infrastructure\Persistence\Doctrine\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Domain\Care\Entity\CarnetSante;
use Domain\Prestation\Entity\Prestation;
use Domain\RendezVous\Entity\RendezVous;
use Domain\Prestataire\Entity\ServicePropose;
use Domain\Animal\Entity\Animal;

class CarePrestationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $animals = $manager->getRepository(Animal::class)->findAll();
        $animalsByNom = []; foreach($animals as $a) $animalsByNom[$a->getNom()] = $a;

        $carnetsData = [
            ['Médor', '10/05/2020', 'Chien en bonne santé générale', ["groupe_sanguin" => "DEA 1.1", "allergies" => ["puces"], "assurance" => "AXA"]],
            ['Kitty', '15/03/2022', 'Chatte stérilisée, tendance surpoids', ["groupe_sanguin" => "A", "micropuce" => "250268700123456"]],
            ['Loulou', '22/08/2021', 'Allergie aux puces, dermatite atopique', ["allergies" => ["puces", "acariens"], "regime" => "hypoallergenique"]],
        ];

        foreach ($carnetsData as $data) {
            $animal = $animalsByNom[$data[0]] ?? null;
            if ($animal) {
                $carnet = CarnetSante::creer(
                    $animal->getId(),
                    $data[2],
                    $data[3],
                    \DateTimeImmutable::createFromFormat('d/m/Y', $data[1])
                );
                $manager->persist($carnet);
            }
        }

        // Prestations
        $rdvs = $manager->getRepository(RendezVous::class)->findAll();
        $proposes = $manager->getRepository(ServicePropose::class)->findAll();

        $prestationsData = [
            [0, 30000, '23/02/2026 09:30'], // Index du RDV dans la liste
            [1, 22000, '23/02/2026 15:30'],
        ];

        foreach ($prestationsData as $data) {
            $rdv = $rdvs[$data[0]] ?? null;
            if ($rdv) {
                $prestation = Prestation::creer(
                    $rdv->getId(),
                    $rdv->getServiceProposeId(),
                    \DateTimeImmutable::createFromFormat('d/m/Y H:i', $data[2]),
                    $data[1]
                );
                $manager->persist($prestation);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            RendezVousFixtures::class,
        ];
    }
}
