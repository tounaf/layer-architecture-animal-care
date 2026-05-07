<?php

namespace Infrastructure\Persistence\Doctrine\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Domain\Prestataire\Entity\Prestataire;
use Domain\Prestataire\Entity\ServicePropose;
use Domain\Service\Entity\Service;

class PrestataireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $prestatairesData = [
            1 => ['Clinique Vétérinaire Analakely', 'Rakoto', 'Jean', 'vétérinaire', true],
            2 => ['Toilettage Canin Isotry', 'Randria', 'Sarah', 'toiletteur', true],
            3 => ['Dr. Rasoa - Vétérinaire à domicile', 'Rasoa', 'Marie', 'vétérinaire', true],
            4 => ['Pension Doggy Palace', 'Rajaonarison', 'Pierre', 'pension', true],
            5 => ['Éducation Canine Tana', 'Rabe', 'Paul', 'éducateur', true],
        ];

        $prestataires = [];
        foreach ($prestatairesData as $id => $data) {
            $prestataire = Prestataire::creer($data[0], $data[1], $data[2], $data[3], $data[4]);
            $manager->persist($prestataire);
            $prestataires[$id] = $prestataire;
        }

        // Mapping codes provided to Service IDs (assumed based on codes from ServiceFixtures)
        $services = $manager->getRepository(Service::class)->findAll();
        $servicesByCode = [];
        foreach ($services as $s) {
            $servicesByCode[$s->getCode()] = $s->getId();
        }

        $proposeData = [
            [1, 'CONS_RDV', true, 'Consultations du lundi au vendredi'],
            [1, 'CONS_DOM', false, 'Pas de visites à domicile actuellement'],
            [1, 'VACC_PRIMO', true, 'Vaccination chiens et chats'],
            [1, 'ANALYSE', true, 'Analyses sur place'],
            [2, 'TOIL_SIMPLE', true, 'Toilettage simple avec produits naturels'],
            [2, 'TOIL_COUPE', true, 'Coupe selon standard de race'],
            [2, 'TOIL_COUPE_DEM', true, 'Pour poils très emmêlés'],
            [3, 'CONS_DOM', true, 'Visites à domicile sur tout Tana'],
            [3, 'CONS_URG', true, 'Urgences 24/7'],
            [3, 'CONS_NUIT', true, 'Consultations de nuit (après 19h)'],
            [3, 'STERIL_MALE_DOM', true, 'Stérilisation mâle à domicile'],
            [4, 'GARD_JOUR', true, 'Garderie de jour avec promenades'],
            [4, 'GARD_NUIT', true, 'Pension nuit en box individuels'],
            [4, 'PENS_COURT', true, 'Séjour court (0-5 jours)'],
            [4, 'PENS_MOYEN', true, 'Séjour moyen (5-15 jours)'],
            [5, 'EDUC_INDIV', true, 'Cours particuliers à domicile'],
            [5, 'EDUC_COLLEC', true, 'Cours collectifs au parc'],
        ];

        foreach ($proposeData as $data) {
            if (isset($servicesByCode[$data[1]])) {
                $servicePropose = ServicePropose::creer(
                    $prestataires[$data[0]]->getId(),
                    $servicesByCode[$data[1]],
                    $data[2],
                    $data[3]
                );
                $manager->persist($servicePropose);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ServiceFixtures::class,
        ];
    }
}
