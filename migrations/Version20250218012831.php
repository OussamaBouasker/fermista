<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250218012831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collier CHANGE reference reference VARCHAR(255) DEFAULT NULL, CHANGE taille taille VARCHAR(255) DEFAULT NULL, CHANGE valeur_temperature valeur_temperature DOUBLE PRECISION DEFAULT NULL, CHANGE valeur_agitation valeur_agitation DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE vache ADD name VARCHAR(255) DEFAULT NULL, CHANGE age age INT DEFAULT NULL, CHANGE race race VARCHAR(255) DEFAULT NULL, CHANGE etat_medical etat_medical VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collier CHANGE reference reference VARCHAR(255) NOT NULL, CHANGE taille taille VARCHAR(255) NOT NULL, CHANGE valeur_temperature valeur_temperature VARCHAR(255) NOT NULL, CHANGE valeur_agitation valeur_agitation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE vache DROP name, CHANGE age age INT NOT NULL, CHANGE race race VARCHAR(255) NOT NULL, CHANGE etat_medical etat_medical VARCHAR(255) NOT NULL');
    }
}
