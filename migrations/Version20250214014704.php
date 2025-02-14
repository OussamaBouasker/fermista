<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250214014704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation CHANGE user_id user_id INT DEFAULT NULL, CHANGE titre titre VARCHAR(30) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE date_soumission date_soumission DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE first_name first_name VARCHAR(10) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation CHANGE user_id user_id INT NOT NULL, CHANGE titre titre VARCHAR(30) NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE date_soumission date_soumission DATETIME NOT NULL');
        $this->addSql('ALTER TABLE `user` CHANGE first_name first_name VARCHAR(100) DEFAULT NULL');
    }
}
