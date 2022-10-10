<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221010095053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_logo ADD user_id INT DEFAULT NULL, ADD brand_name VARCHAR(75) DEFAULT NULL, ADD activity VARCHAR(75) DEFAULT NULL, ADD budget VARCHAR(50) NOT NULL, ADD start_date DATE DEFAULT NULL, ADD explanation LONGTEXT NOT NULL, ADD desired_colors VARCHAR(255) DEFAULT NULL, ADD unwanted_colors VARCHAR(255) DEFAULT NULL, ADD other_brands VARCHAR(75) DEFAULT NULL, ADD support VARCHAR(75) DEFAULT NULL, ADD creation TINYINT(1) DEFAULT NULL, ADD img_format VARCHAR(75) DEFAULT NULL, ADD background TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_logo ADD CONSTRAINT FK_DD1F520BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_DD1F520BA76ED395 ON project_logo (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_logo DROP FOREIGN KEY FK_DD1F520BA76ED395');
        $this->addSql('DROP INDEX IDX_DD1F520BA76ED395 ON project_logo');
        $this->addSql('ALTER TABLE project_logo DROP user_id, DROP brand_name, DROP activity, DROP budget, DROP start_date, DROP explanation, DROP desired_colors, DROP unwanted_colors, DROP other_brands, DROP support, DROP creation, DROP img_format, DROP background');
    }
}
