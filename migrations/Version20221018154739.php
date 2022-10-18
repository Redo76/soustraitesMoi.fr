<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018154739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_logo ADD statut TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_reseaux ADD statut TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_site ADD statut TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_logo DROP statut');
        $this->addSql('ALTER TABLE project_reseaux DROP statut');
        $this->addSql('ALTER TABLE project_site DROP statut');
    }
}
