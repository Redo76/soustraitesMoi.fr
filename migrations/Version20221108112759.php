<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221108112759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP paid');
        $this->addSql('ALTER TABLE project_logo DROP paid');
        $this->addSql('ALTER TABLE project_reseaux DROP paid');
        $this->addSql('ALTER TABLE project_site DROP paid');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD paid TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_logo ADD paid TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_reseaux ADD paid TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_site ADD paid TINYINT(1) DEFAULT NULL');
    }
}
