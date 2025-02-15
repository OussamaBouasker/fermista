<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250213170106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collier CHANGE reference reference VARCHAR(255) DEFAULT NULL, CHANGE taille taille VARCHAR(255) DEFAULT NULL, CHANGE valeur_temperature valeur_temperature VARCHAR(255) DEFAULT NULL, CHANGE valeur_agitation valeur_agitation VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collier CHANGE reference reference VARCHAR(255) NOT NULL, CHANGE taille taille VARCHAR(255) NOT NULL, CHANGE valeur_temperature valeur_temperature VARCHAR(255) NOT NULL, CHANGE valeur_agitation valeur_agitation VARCHAR(255) NOT NULL');
    }
}
