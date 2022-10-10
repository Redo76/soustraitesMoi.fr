<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221010141453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_reseaux (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, brand_name VARCHAR(75) DEFAULT NULL, activity VARCHAR(75) DEFAULT NULL, budget VARCHAR(50) NOT NULL, start_date DATE DEFAULT NULL, mission_duration VARCHAR(50) DEFAULT NULL, publication VARCHAR(50) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, location VARCHAR(200) DEFAULT NULL, snapchat VARCHAR(255) DEFAULT NULL, tiktok VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, linkedin VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, pinterest VARCHAR(255) DEFAULT NULL, other_media VARCHAR(255) DEFAULT NULL, community_manager VARCHAR(200) DEFAULT NULL, impact LONGTEXT DEFAULT NULL, desired_colors VARCHAR(255) DEFAULT NULL, liked_example LONGTEXT DEFAULT NULL, INDEX IDX_DFB5C474A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_reseaux ADD CONSTRAINT FK_DFB5C474A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE image ADD project_reseaux_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F2124502A FOREIGN KEY (project_reseaux_id) REFERENCES project_reseaux (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F2124502A ON image (project_reseaux_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F2124502A');
        $this->addSql('ALTER TABLE project_reseaux DROP FOREIGN KEY FK_DFB5C474A76ED395');
        $this->addSql('DROP TABLE project_reseaux');
        $this->addSql('DROP INDEX IDX_C53D045F2124502A ON image');
        $this->addSql('ALTER TABLE image DROP project_reseaux_id');
    }
}
