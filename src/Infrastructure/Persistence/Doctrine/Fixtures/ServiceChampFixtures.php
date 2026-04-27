<?php

namespace Infrastructure\Persistence\Doctrine\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Domain\Service\Entity\ServiceChamp;

class ServiceChampFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $champs = [
            ['motif', 'textarea', 'Motif de la consultation', true],
            ['diagnostic', 'textarea', 'Diagnostic établi', false],
            ['examen_clinique', 'textarea', 'Résultats de l\'examen', false],
            ['lot_vaccin', 'text', 'Numéro de lot du vaccin', false],
            ['date_rappel', 'date', 'Date du prochain rappel', false],
            ['produit_vermifuge', 'text', 'Produit utilisé', true],
            ['dose_vermifuge', 'text', 'Dose administrée', true],
            ['type_coupe', 'select', 'Type de coupe (toilettage)', true],
            ['instructions_pension', 'textarea', 'Instructions spéciales pour pension', false],
            ['date_depot', 'datetime', 'Date et heure de dépôt', true],
            ['date_recuperation', 'datetime', 'Date et heure de récupération', true],
            ['type_anesthesie', 'text', 'Protocole anesthésique', true],
            ['compte_rendu_op', 'textarea', 'Compte-rendu opératoire', true],
            ['exercices_dressage', 'textarea', 'Exercices réalisés', true],
            ['photo_avant', 'file', 'Photo avant prestation', false],
            ['photo_apres', 'file', 'Photo après prestation', false],
        ];

        foreach ($champs as $data) {
            $champ = ServiceChamp::creer($data[0], $data[1], $data[2], $data[3]);
            $manager->persist($champ);
        }

        $manager->flush();
    }
}
