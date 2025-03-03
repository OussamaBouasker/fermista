<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250224112245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collier CHANGE reference reference VARCHAR(255) DEFAULT NULL, CHANGE taille taille VARCHAR(255) DEFAULT NULL, CHANGE valeur_temperature valeur_temperature DOUBLE PRECISION DEFAULT NULL, CHANGE valeur_agitation valeur_agitation DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE consultation ADD nom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison ADD lieu VARCHAR(255) DEFAULT NULL, DROP heure, CHANGE date date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD image VARCHAR(255) DEFAULT NULL, CHANGE prix prix NUMERIC(10, 2) DEFAULT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE categorie categorie VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD sex VARCHAR(50) NOT NULL, DROP jour, CHANGE date date DATE NOT NULL, CHANGE heure heure TIME NOT NULL, CHANGE cause cause VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD email VARCHAR(255) DEFAULT NULL, ADD num_tel INT DEFAULT NULL, ADD num_carte_bancaire VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE vache ADD name VARCHAR(255) DEFAULT NULL, CHANGE age age INT DEFAULT NULL, CHANGE race race VARCHAR(255) DEFAULT NULL, CHANGE etat_medical etat_medical VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE workshop ADD meetlink VARCHAR(255) DEFAULT NULL, CHANGE nbr_places_max_ nbr_places_max INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collier CHANGE reference reference VARCHAR(255) NOT NULL, CHANGE taille taille VARCHAR(255) NOT NULL, CHANGE valeur_temperature valeur_temperature VARCHAR(255) NOT NULL, CHANGE valeur_agitation valeur_agitation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE consultation DROP nom');
        $this->addSql('ALTER TABLE livraison ADD heure DATETIME DEFAULT NULL, DROP lieu, CHANGE date date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE produit DROP image, CHANGE prix prix NUMERIC(10, 0) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE categorie categorie VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD jour VARCHAR(50) DEFAULT NULL, DROP sex, CHANGE date date DATE DEFAULT NULL, CHANGE heure heure TIME DEFAULT NULL, CHANGE cause cause VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation DROP email, DROP num_tel, DROP num_carte_bancaire');
        $this->addSql('ALTER TABLE vache DROP name, CHANGE age age INT NOT NULL, CHANGE race race VARCHAR(255) NOT NULL, CHANGE etat_medical etat_medical VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE workshop DROP meetlink, CHANGE nbr_places_max nbr_places_max_ INT DEFAULT NULL');
    }
}
