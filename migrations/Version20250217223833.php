<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217223833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation ADD nom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD sex VARCHAR(50) NOT NULL, DROP jour, CHANGE date date DATE NOT NULL, CHANGE heure heure TIME NOT NULL, CHANGE cause cause VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP nom');
        $this->addSql('ALTER TABLE rendez_vous ADD jour VARCHAR(50) DEFAULT NULL, DROP sex, CHANGE date date DATE DEFAULT NULL, CHANGE heure heure TIME DEFAULT NULL, CHANGE cause cause VARCHAR(255) DEFAULT NULL');
    }
}
