<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250211092408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rapport_medical (id INT AUTO_INCREMENT NOT NULL, num INT DEFAULT NULL, race VARCHAR(50) DEFAULT NULL, historique_de_maladie VARCHAR(255) DEFAULT NULL, cas_medical VARCHAR(255) DEFAULT NULL, solution VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, date DATE DEFAULT NULL, heure TIME DEFAULT NULL, jour VARCHAR(50) DEFAULT NULL, cause VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vache (id INT AUTO_INCREMENT NOT NULL, age INT NOT NULL, race VARCHAR(255) NOT NULL, etat_medical VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collier ADD CONSTRAINT FK_1225992390065A44 FOREIGN KEY (vache_id) REFERENCES vache (id)');
        $this->addSql('ALTER TABLE consultation ADD rapportmedical_id INT DEFAULT NULL, DROP jour, CHANGE cause lieu VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A617D4704B FOREIGN KEY (rapportmedical_id) REFERENCES rapport_medical (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_964685A617D4704B ON consultation (rapportmedical_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A617D4704B');
        $this->addSql('ALTER TABLE collier DROP FOREIGN KEY FK_1225992390065A44');
        $this->addSql('DROP TABLE rapport_medical');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE vache');
        $this->addSql('DROP INDEX UNIQ_964685A617D4704B ON consultation');
        $this->addSql('ALTER TABLE consultation ADD jour VARCHAR(50) DEFAULT NULL, DROP rapportmedical_id, CHANGE lieu cause VARCHAR(255) DEFAULT NULL');
    }
}
