<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217005638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reclamation CHANGE user_id user_id INT DEFAULT NULL, CHANGE titre titre VARCHAR(30) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE date_soumission date_soumission DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(10) DEFAULT NULL, ADD last_name VARCHAR(50) DEFAULT NULL, ADD number VARCHAR(15) DEFAULT NULL, ADD state TINYINT(1) DEFAULT NULL, ADD is_verified TINYINT(1) NOT NULL, CHANGE email email VARCHAR(180) DEFAULT NULL, CHANGE roles roles JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE reclamation CHANGE user_id user_id INT NOT NULL, CHANGE titre titre VARCHAR(30) NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE date_soumission date_soumission DATETIME NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP first_name, DROP last_name, DROP number, DROP state, DROP is_verified, CHANGE email email VARCHAR(180) NOT NULL, CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL');
    }
}
