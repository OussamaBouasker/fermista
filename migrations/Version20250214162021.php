<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250214162021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison ADD lieu VARCHAR(255) DEFAULT NULL, DROP heure');
        $this->addSql('ALTER TABLE produit CHANGE prix prix NUMERIC(10, 2) DEFAULT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE categorie categorie VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE workshop ADD nbr_places_max_ INT DEFAULT NULL, ADD nbr_places_restantes INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison ADD heure DATETIME DEFAULT NULL, DROP lieu');
        $this->addSql('ALTER TABLE produit CHANGE prix prix NUMERIC(10, 0) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE categorie categorie VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE workshop DROP nbr_places_max_, DROP nbr_places_restantes');
    }
}
