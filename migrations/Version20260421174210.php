<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260421174210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (nom VARCHAR(255) NOT NULL, espece VARCHAR(255) DEFAULT NULL, race VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, proprietaire_id VARCHAR(255) DEFAULT NULL, id VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE carnet_sante (animal_id VARCHAR(255) NOT NULL, informations_generales LONGTEXT DEFAULT NULL, metadonnees JSON NOT NULL, date_creation DATETIME NOT NULL, date_derniere_mise_a_jour DATETIME NOT NULL, id VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE client (nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, id VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C7440455E7927C74 (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE entree_carnet (type VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, etabli_par_id VARCHAR(255) NOT NULL, visible_proprietaire TINYINT NOT NULL, date_entree DATETIME NOT NULL, date_modification DATETIME NOT NULL, date_rappel DATE DEFAULT NULL, donnees_structurees JSON NOT NULL, id VARCHAR(255) NOT NULL, carnet_sante_id VARCHAR(255) NOT NULL, INDEX IDX_DC419094590947D0 (carnet_sante_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE rendez_vous (client_id VARCHAR(255) NOT NULL, animal_id VARCHAR(255) NOT NULL, prestataire_id VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, commentaires LONGTEXT DEFAULT NULL, id VARCHAR(255) NOT NULL, heure_debut VARCHAR(5) NOT NULL, heure_fin VARCHAR(5) NOT NULL, duree_minutes INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE service (nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, actif TINYINT NOT NULL, id VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, devise VARCHAR(3) NOT NULL, date_application DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE entree_carnet ADD CONSTRAINT FK_DC419094590947D0 FOREIGN KEY (carnet_sante_id) REFERENCES carnet_sante (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entree_carnet DROP FOREIGN KEY FK_DC419094590947D0');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE carnet_sante');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE entree_carnet');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
