<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241005131831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de l\'entité "Entreprise" et de ses relations avec Offre et Service';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE entreprise_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE entreprise (id INT NOT NULL, nom VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE offre ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_AF86866FA4AEAFEA ON offre (entreprise_id)');
        $this->addSql('ALTER TABLE service ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E19D9AD2A4AEAFEA ON service (entreprise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866FA4AEAFEA');
        $this->addSql('ALTER TABLE service DROP CONSTRAINT FK_E19D9AD2A4AEAFEA');
        $this->addSql('DROP SEQUENCE entreprise_id_seq CASCADE');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP INDEX IDX_AF86866FA4AEAFEA');
        $this->addSql('ALTER TABLE offre DROP entreprise_id');
        $this->addSql('DROP INDEX IDX_E19D9AD2A4AEAFEA');
        $this->addSql('ALTER TABLE service DROP entreprise_id');
    }
}
