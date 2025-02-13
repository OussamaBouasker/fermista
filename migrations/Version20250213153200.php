<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250213153200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD livcom_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DD90C960B FOREIGN KEY (livcom_id) REFERENCES livraison (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DD90C960B ON commande (livcom_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DD90C960B');
        $this->addSql('DROP INDEX IDX_6EEAA67DD90C960B ON commande');
        $this->addSql('ALTER TABLE commande DROP livcom_id');
    }
}
