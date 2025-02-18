<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217231149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison ADD lieu VARCHAR(255) DEFAULT NULL, DROP heure, CHANGE date date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD image VARCHAR(255) DEFAULT NULL, CHANGE prix prix NUMERIC(10, 2) DEFAULT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE categorie categorie VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison ADD heure DATETIME DEFAULT NULL, DROP lieu, CHANGE date date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE produit DROP image, CHANGE prix prix NUMERIC(10, 0) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE categorie categorie VARCHAR(255) DEFAULT NULL');
    }
}
