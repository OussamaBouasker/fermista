<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250211022829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE collier (id INT AUTO_INCREMENT NOT NULL, vache_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, taille VARCHAR(255) NOT NULL, valeur_temperature VARCHAR(255) NOT NULL, valeur_agitation VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1225992390065A44 (vache_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vache (id INT AUTO_INCREMENT NOT NULL, age INT NOT NULL, race VARCHAR(255) NOT NULL, etat_medical VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collier ADD CONSTRAINT FK_1225992390065A44 FOREIGN KEY (vache_id) REFERENCES vache (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collier DROP FOREIGN KEY FK_1225992390065A44');
        $this->addSql('DROP TABLE collier');
        $this->addSql('DROP TABLE vache');
    }
}
