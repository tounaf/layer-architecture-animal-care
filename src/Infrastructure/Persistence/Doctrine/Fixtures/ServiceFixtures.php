<?php

namespace Infrastructure\Persistence\Doctrine\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Domain\Service\Entity\Service;
use Domain\Service\Entity\ServiceCategorie;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoriesData = [
            1 => ['Consultations vétérinaires', 'Consultations et visites', null, 1],
            2 => ['Vaccinations', 'Vaccins et rappels', null, 2],
            3 => ['Vermifugation', 'Ody kakana', null, 3],
            4 => ['Toilettage', 'Soins esthétiques', 'ti ti-cut', 4],
            5 => ['Pension/Garderie', "Garde d'animaux", null, 5],
            6 => ['Analyses & Imagerie', 'Examens complémentaires', null, 6],
            7 => ['Chirurgie', 'Interventions', null, 7],
            8 => ['Éducation canine', 'Dressage', null, 8],
        ];

        $categories = [];
        foreach ($categoriesData as $id => $data) {
            $categorie = ServiceCategorie::creer($data[0], $data[1], $data[2], $data[3]);
            $manager->persist($categorie);
            $categories[$id] = $categorie;
        }

        $servicesData = [
            [1, 'CONS_RDV', 'Consultation sur rendez-vous', 'Consultation vétérinaire standard', 30, true],
            [1, 'CONS_DOM', 'Visite à domicile', 'Consultation à domicile', 45, true],
            [1, 'CONS_URG', "Consultation d'urgence", 'Urgence vétérinaire', 30, true],
            [1, 'CONS_CTRL', 'Consultation de contrôle', 'Suivi post-traitement', 20, false],
            [1, 'CONS_RENTE', 'Consultation animal de rente', 'Pour bovins, ovins, etc.', 45, true],
            [1, 'CONS_NAC', 'Consultation NAC', 'Nouveaux animaux de compagnie', 40, true],
            [1, 'CONS_NUIT', 'Consultation de nuit', 'Après 19h', 30, true],
            [2, 'VACC_PRIMO', 'Primo vaccination (<5 sem)', 'Première vaccination', 15, true],
            [2, 'VACC_PRIMO_RAP', 'Primo vaccination - rappel', 'Rappel primo vaccination', 15, true],
            [2, 'VACC_COMPLETE', 'Vaccination complète (>3 mois)', 'Vaccination complète', 20, true],
            [2, 'VACC_COMPLETE_RAP', 'Vaccination complète - rappel', 'Rappel vaccination complète', 15, true],
            [3, 'VERMIF', 'Vermifugation (ody kakana)', 'Traitement antiparasitaire', 10, true],
            [4, 'TOIL_SIMPLE', 'Toilettage simple', 'Brossage, bain', 60, true],
            [4, 'TOIL_COUPE', 'Toilettage avec coupe', 'Coupe de poils', 90, true],
            [4, 'TOIL_COUPE_DEM', 'Toilettage avec coupe et démêlage', 'Coupe + démêlage', 120, true],
            [4, 'TOIL_DEM', 'Toilettage avec démêlage', 'Démêlage uniquement', 90, true],
            [5, 'GARD_JOUR', 'Garderie de jour', 'Dépôt/récupération journée', 480, true],
            [5, 'GARD_NUIT', 'Garderie de nuit', 'Nuit complète', 720, true],
            [5, 'PENS_COURT', 'Pension 0-5 jours', 'Séjour court', 2880, true],
            [5, 'PENS_MOYEN', 'Pension 5-15 jours', 'Séjour moyen', 7200, true],
            [5, 'PENS_LONG', 'Pension plus de 15 jours', 'Long séjour', 14400, true],
            [6, 'ANALYSE', 'Analyses complémentaires', 'Prises de sang, etc.', 30, true],
            [6, 'IMAGERIE', 'Imagerie', 'Radio, échographie', 45, true],
            [7, 'CHIRURGIE', 'Chirurgie générale', 'Interventions diverses', 120, true],
            [7, 'STERIL_MALE_DOM', 'Stérilisation mâle à domicile', 'Castration à domicile', 60, true],
            [7, 'STERIL_FEM', 'Stérilisation femelle', 'Ovario-hystérectomie', 90, true],
            [7, 'CASTRA', 'Castration', 'Petite chirurgie', 60, true],
            [7, 'PETITE_CHIR', 'Petite chirurgie', 'Sutures, etc.', 45, true],
            [8, 'EDUC_INDIV', 'Éducation canine individuelle', 'Séance particulière', 60, true],
            [8, 'EDUC_COLLEC', 'Éducation canine collective', 'Cours en groupe', 90, true],
            [8, 'DRESSAGE', 'Dressage spécifique', 'Dressage avancé', 60, true],
        ];

        foreach ($servicesData as $data) {
            $service = Service::creer(
                $data[2],
                $data[1],
                $categories[$data[0]],
                $data[4],
                $data[5],
                $data[3]
            );
            $manager->persist($service);
        }

        $manager->flush();
    }
}
