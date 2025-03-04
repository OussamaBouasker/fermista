<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250215142108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE collier (id INT AUTO_INCREMENT NOT NULL, vache_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, taille VARCHAR(255) NOT NULL, valeur_temperature VARCHAR(255) NOT NULL, valeur_agitation VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1225992390065A44 (vache_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, livcom_id INT DEFAULT NULL, date_commande DATETIME DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, montant_total DOUBLE PRECISION DEFAULT NULL, INDEX IDX_6EEAA67DD90C960B (livcom_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, date DATE DEFAULT NULL, heure DATETIME DEFAULT NULL, livreur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prix NUMERIC(10, 0) DEFAULT NULL, etat VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, categorie VARCHAR(255) DEFAULT NULL, INDEX IDX_29A5EC2782EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, titre VARCHAR(30) NOT NULL, description LONGTEXT NOT NULL, status VARCHAR(255) DEFAULT NULL, date_soumission DATETIME NOT NULL, INDEX IDX_CE606404A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, workshop_id INT DEFAULT NULL, reservation_date DATETIME DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, prix VARCHAR(255) DEFAULT NULL, commentaire VARCHAR(255) DEFAULT NULL, confirmation TINYINT(1) DEFAULT NULL, INDEX IDX_42C849551FDCE57C (workshop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vache (id INT AUTO_INCREMENT NOT NULL, age INT NOT NULL, race VARCHAR(255) NOT NULL, etat_medical VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshop (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, prix VARCHAR(255) DEFAULT NULL, theme VARCHAR(255) DEFAULT NULL, duration TIME DEFAULT NULL, nbr_places_max_ INT DEFAULT NULL, nbr_places_restantes INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collier ADD CONSTRAINT FK_1225992390065A44 FOREIGN KEY (vache_id) REFERENCES vache (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DD90C960B FOREIGN KEY (livcom_id) REFERENCES livraison (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2782EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849551FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshop (id)');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A617D4704B');
        $this->addSql('DROP INDEX UNIQ_964685A617D4704B ON consultation');
        $this->addSql('ALTER TABLE consultation DROP rapportmedical_id');
        $this->addSql('ALTER TABLE rapport_medical ADD consultation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_medical ADD CONSTRAINT FK_C0B673962FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0B673962FF6CDF ON rapport_medical (consultation_id)');
        $this->addSql('ALTER TABLE rendez_vous ADD sex VARCHAR(50) NOT NULL, DROP jour, CHANGE date date DATE NOT NULL, CHANGE heure heure TIME NOT NULL, CHANGE cause cause VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collier DROP FOREIGN KEY FK_1225992390065A44');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DD90C960B');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2782EA2E54');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849551FDCE57C');
        $this->addSql('DROP TABLE collier');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE vache');
        $this->addSql('DROP TABLE workshop');
        $this->addSql('ALTER TABLE consultation ADD rapportmedical_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A617D4704B FOREIGN KEY (rapportmedical_id) REFERENCES rapport_medical (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_964685A617D4704B ON consultation (rapportmedical_id)');
        $this->addSql('ALTER TABLE rapport_medical DROP FOREIGN KEY FK_C0B673962FF6CDF');
        $this->addSql('DROP INDEX UNIQ_C0B673962FF6CDF ON rapport_medical');
        $this->addSql('ALTER TABLE rapport_medical DROP consultation_id');
        $this->addSql('ALTER TABLE rendez_vous ADD jour VARCHAR(50) DEFAULT NULL, DROP sex, CHANGE date date DATE DEFAULT NULL, CHANGE heure heure TIME DEFAULT NULL, CHANGE cause cause VARCHAR(255) DEFAULT NULL');
    }
}
