<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250304020708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arg_agit (id INT AUTO_INCREMENT NOT NULL, accel_x VARCHAR(255) DEFAULT NULL, accel_y VARCHAR(255) DEFAULT NULL, accel_z VARCHAR(255) DEFAULT NULL, time_receive DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE arg_temp (id INT AUTO_INCREMENT NOT NULL, temperature VARCHAR(255) DEFAULT NULL, time_receive DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consultation ADD vache_id INT NOT NULL');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A690065A44 FOREIGN KEY (vache_id) REFERENCES vache (id)');
        $this->addSql('CREATE INDEX IDX_964685A690065A44 ON consultation (vache_id)');
        $this->addSql('ALTER TABLE rendez_vous ADD veterinaire_id INT DEFAULT NULL, ADD agriculteur_id INT DEFAULT NULL, ADD status VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A5C80924 FOREIGN KEY (veterinaire_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A7EBB810E FOREIGN KEY (agriculteur_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A5C80924 ON rendez_vous (veterinaire_id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A7EBB810E ON rendez_vous (agriculteur_id)');
        $this->addSql('ALTER TABLE user ADD image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE arg_agit');
        $this->addSql('DROP TABLE arg_temp');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A690065A44');
        $this->addSql('DROP INDEX IDX_964685A690065A44 ON consultation');
        $this->addSql('ALTER TABLE consultation DROP vache_id');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A5C80924');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A7EBB810E');
        $this->addSql('DROP INDEX IDX_65E8AA0A5C80924 ON rendez_vous');
        $this->addSql('DROP INDEX IDX_65E8AA0A7EBB810E ON rendez_vous');
        $this->addSql('ALTER TABLE rendez_vous DROP veterinaire_id, DROP agriculteur_id, DROP status');
        $this->addSql('ALTER TABLE `user` DROP image');
    }
}
