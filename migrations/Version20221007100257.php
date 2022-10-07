<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007100257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_logo (id INT AUTO_INCREMENT NOT NULL, brand_name VARCHAR(75) DEFAULT NULL, activity VARCHAR(75) DEFAULT NULL, budget VARCHAR(50) NOT NULL, start_date DATE NOT NULL, explanation LONGTEXT NOT NULL, desired_colors VARCHAR(255) DEFAULT NULL, unwanted_colors VARCHAR(255) DEFAULT NULL, other_brands VARCHAR(75) DEFAULT NULL, support VARCHAR(75) DEFAULT NULL, creation VARCHAR(25) DEFAULT NULL, img_format VARCHAR(75) DEFAULT NULL, background VARCHAR(15) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD goodproject_logo_id INT DEFAULT NULL, ADD bad_project_logo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA5B0A33 FOREIGN KEY (goodproject_logo_id) REFERENCES project_logo (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F33B5EF44 FOREIGN KEY (bad_project_logo_id) REFERENCES project_logo (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FA5B0A33 ON image (goodproject_logo_id)');
        $this->addSql('CREATE INDEX IDX_C53D045F33B5EF44 ON image (bad_project_logo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA5B0A33');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F33B5EF44');
        $this->addSql('DROP TABLE project_logo');
        $this->addSql('DROP INDEX IDX_C53D045FA5B0A33 ON image');
        $this->addSql('DROP INDEX IDX_C53D045F33B5EF44 ON image');
        $this->addSql('ALTER TABLE image DROP goodproject_logo_id, DROP bad_project_logo_id');
    }
}
