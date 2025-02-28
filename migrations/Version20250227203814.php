<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250227203814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A690065A44 FOREIGN KEY (vache_id) REFERENCES vache (id)');
        $this->addSql('CREATE INDEX IDX_964685A690065A44 ON consultation (vache_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A690065A44');
        $this->addSql('DROP INDEX IDX_964685A690065A44 ON consultation');
    }
}
