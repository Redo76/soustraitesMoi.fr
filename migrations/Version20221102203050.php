<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221102203050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project_logo ADD session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project_reseaux ADD session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project_site ADD session_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP session_id');
        $this->addSql('ALTER TABLE project_logo DROP session_id');
        $this->addSql('ALTER TABLE project_reseaux DROP session_id');
        $this->addSql('ALTER TABLE project_site DROP session_id');
    }
}
