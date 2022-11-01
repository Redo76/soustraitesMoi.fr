<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221101121701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD price VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_logo ADD price VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_reseaux ADD price VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_site ADD price VARCHAR(15) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP price');
        $this->addSql('ALTER TABLE project_logo DROP price');
        $this->addSql('ALTER TABLE project_reseaux DROP price');
        $this->addSql('ALTER TABLE project_site DROP price');
    }
}
