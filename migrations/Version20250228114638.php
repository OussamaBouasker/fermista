<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250228114638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE collier (id INT AUTO_INCREMENT NOT NULL, vache_id INT DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, taille VARCHAR(255) DEFAULT NULL, valeur_temperature DOUBLE PRECISION DEFAULT NULL, valeur_agitation DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_1225992390065A44 (vache_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, livcom_id INT DEFAULT NULL, date_commande DATETIME DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, montant_total DOUBLE PRECISION DEFAULT NULL, INDEX IDX_6EEAA67DD90C960B (livcom_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, rapportmedical_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, heure TIME DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_964685A617D4704B (rapportmedical_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, date DATETIME DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, livreur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prix NUMERIC(10, 2) DEFAULT NULL, etat VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, categorie VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_29A5EC2782EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport_medical (id INT AUTO_INCREMENT NOT NULL, num INT DEFAULT NULL, race VARCHAR(50) DEFAULT NULL, historique_de_maladie VARCHAR(255) DEFAULT NULL, cas_medical VARCHAR(255) DEFAULT NULL, solution VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, titre VARCHAR(30) DEFAULT NULL, description LONGTEXT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, date_soumission DATETIME DEFAULT NULL, INDEX IDX_CE606404A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, heure TIME NOT NULL, sex VARCHAR(50) NOT NULL, cause VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, workshop_id INT DEFAULT NULL, user_id INT DEFAULT NULL, reservation_date DATETIME DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, prix VARCHAR(255) DEFAULT NULL, commentaire VARCHAR(255) DEFAULT NULL, confirmation TINYINT(1) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, num_tel INT DEFAULT NULL, num_carte_bancaire VARCHAR(255) DEFAULT NULL, INDEX IDX_42C849551FDCE57C (workshop_id), INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) DEFAULT NULL, roles JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) DEFAULT NULL, first_name VARCHAR(10) DEFAULT NULL, last_name VARCHAR(50) DEFAULT NULL, number VARCHAR(15) DEFAULT NULL, state TINYINT(1) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vache (id INT AUTO_INCREMENT NOT NULL, age INT DEFAULT NULL, race VARCHAR(255) DEFAULT NULL, etat_medical VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshop (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, prix VARCHAR(255) DEFAULT NULL, theme VARCHAR(255) DEFAULT NULL, duration TIME DEFAULT NULL, nbr_places_max INT DEFAULT NULL, nbr_places_restantes INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, meetlink VARCHAR(255) DEFAULT NULL, INDEX IDX_9B6F02C4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collier ADD CONSTRAINT FK_1225992390065A44 FOREIGN KEY (vache_id) REFERENCES vache (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DD90C960B FOREIGN KEY (livcom_id) REFERENCES livraison (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A617D4704B FOREIGN KEY (rapportmedical_id) REFERENCES rapport_medical (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2782EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849551FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshop (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE workshop ADD CONSTRAINT FK_9B6F02C4A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collier DROP FOREIGN KEY FK_1225992390065A44');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DD90C960B');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A617D4704B');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2782EA2E54');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849551FDCE57C');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE workshop DROP FOREIGN KEY FK_9B6F02C4A76ED395');
        $this->addSql('DROP TABLE collier');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE rapport_medical');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE vache');
        $this->addSql('DROP TABLE workshop');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
