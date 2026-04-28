<?php

namespace Infrastructure\Persistence\Doctrine\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Domain\Prestation\Entity\Prestation;
use Domain\Service\Entity\ServiceChamp;
use Domain\RendezVous\Entity\RendezVous;
use Domain\Document\Entity\Document;

class PrestationValeurFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $champs = $manager->getRepository(ServiceChamp::class)->findAll();
        $champsByNom = []; foreach($champs as $c) $champsByNom[$c->getNom()] = $c;

        $rdvs = $manager->getRepository(RendezVous::class)->findAll();
        
        // Documents
        $doc1 = Document::creer('prestation_id_dummy', 'analyse', 'bilan_sang_kitty.pdf', '/uploads/2026/02/bilan_sang_kitty.pdf', 'application/pdf', 245000, "Résultats analyse sanguine");
        $doc2 = Document::creer('prestation_id_dummy', 'photo', 'cicatrice_kitty_j+10.jpg', '/uploads/2026/02/cicatrice_kitty.jpg', 'image/jpeg', 1250000, "Contrôle cicatrice J+10");
        $doc3 = Document::creer('prestation_id_dummy', 'ordonnance', 'ordonnance_medor_20260224.pdf', '/uploads/2026/02/ordonnance_medor.pdf', 'application/pdf', 180000, "Ordonnance traitement gastro");

        $manager->persist($doc1);
        $manager->persist($doc2);
        $manager->persist($doc3);

        // Prestation 1
        if (isset($rdvs[0])) {
            $prestation1 = Prestation::creer($rdvs[0]->getId(), $rdvs[0]->getServiceProposeId(), new \DateTimeImmutable('2026-02-23 09:30'), 30000);
            $prestation1->ajouterValeurChamp($champsByNom['motif']->getId(), "Vomissements depuis 2 jours");
            $prestation1->ajouterValeurChamp($champsByNom['examen_clinique']->getId(), "Température 38.9, abdomen sensible");
            $prestation1->ajouterValeurChamp($champsByNom['diagnostic']->getId(), "Gastro-entérite légère");
            $manager->persist($prestation1);
        }

        // Prestation 2
        if (isset($rdvs[1])) {
            $prestation2 = Prestation::creer($rdvs[1]->getId(), $rdvs[1]->getServiceProposeId(), new \DateTimeImmutable('2026-02-23 15:30'), 22000);
            $prestation2->ajouterValeurChamp($champsByNom['type_coupe']->getId(), "Coupe standard caniche");
            $prestation2->ajouterValeurChamp($champsByNom['photo_avant']->getId(), "/uploads/2026/02/medor_avant.jpg", 'fichier', $doc1->getId());
            $prestation2->ajouterValeurChamp($champsByNom['photo_apres']->getId(), "/uploads/2026/02/medor_apres.jpg", 'fichier', $doc2->getId());
            $manager->persist($prestation2);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ServiceChampFixtures::class,
            RendezVousFixtures::class,
        ];
    }
}
