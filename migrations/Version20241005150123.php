<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241005150123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Suppression des propriétés (column) service_id de la table offre';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT fk_af86866fed5ca9e6');
        $this->addSql('DROP INDEX idx_af86866fed5ca9e6');
        $this->addSql('ALTER TABLE offre DROP service_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE offre ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT fk_af86866fed5ca9e6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_af86866fed5ca9e6 ON offre (service_id)');
    }
}
