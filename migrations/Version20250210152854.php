<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210152854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation ADD rapportmedical_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A617D4704B FOREIGN KEY (rapportmedical_id) REFERENCES rapport_medical (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_964685A617D4704B ON consultation (rapportmedical_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A617D4704B');
        $this->addSql('DROP INDEX UNIQ_964685A617D4704B ON consultation');
        $this->addSql('ALTER TABLE consultation DROP rapportmedical_id');
    }
}
