<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221014083935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_site (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, presentation LONGTEXT DEFAULT NULL, activity VARCHAR(75) DEFAULT NULL, offers VARCHAR(150) DEFAULT NULL, service VARCHAR(150) DEFAULT NULL, valeurs VARCHAR(150) DEFAULT NULL, main_objective LONGTEXT DEFAULT NULL, secondary_objective LONGTEXT DEFAULT NULL, profil_client LONGTEXT DEFAULT NULL, homepage LONGTEXT DEFAULT NULL, about LONGTEXT DEFAULT NULL, our_services LONGTEXT DEFAULT NULL, contact LONGTEXT DEFAULT NULL, contact_form VARCHAR(50) DEFAULT NULL, search_bar VARCHAR(50) DEFAULT NULL, catalogue VARCHAR(50) DEFAULT NULL, client VARCHAR(50) DEFAULT NULL, newsletter VARCHAR(50) DEFAULT NULL, logo VARCHAR(150) DEFAULT NULL, visuals VARCHAR(255) DEFAULT NULL, typography VARCHAR(50) DEFAULT NULL, colors VARCHAR(50) DEFAULT NULL, loved_sites VARCHAR(255) DEFAULT NULL, other_site LONGTEXT DEFAULT NULL, INDEX IDX_50D2C1FCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_site ADD CONSTRAINT FK_50D2C1FCA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA5B0A33');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F2124502A');
        $this->addSql('DROP INDEX IDX_C53D045FA5B0A33 ON image');
        $this->addSql('DROP INDEX IDX_C53D045F2124502A ON image');
        $this->addSql('ALTER TABLE image ADD good_project_logo_id INT DEFAULT NULL, ADD project_reseaux_logo_id INT DEFAULT NULL, ADD example_id INT DEFAULT NULL, ADD visuals_id INT DEFAULT NULL, ADD logo_site_id INT DEFAULT NULL, DROP goodproject_logo_id, DROP project_reseaux_id');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F62E699E FOREIGN KEY (good_project_logo_id) REFERENCES project_logo (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FDC2DBB8B FOREIGN KEY (project_reseaux_logo_id) REFERENCES project_reseaux (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FAB07C711 FOREIGN KEY (example_id) REFERENCES project_reseaux (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FB72964A FOREIGN KEY (visuals_id) REFERENCES project_site (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FC297FC36 FOREIGN KEY (logo_site_id) REFERENCES project_site (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F62E699E ON image (good_project_logo_id)');
        $this->addSql('CREATE INDEX IDX_C53D045FDC2DBB8B ON image (project_reseaux_logo_id)');
        $this->addSql('CREATE INDEX IDX_C53D045FAB07C711 ON image (example_id)');
        $this->addSql('CREATE INDEX IDX_C53D045FB72964A ON image (visuals_id)');
        $this->addSql('CREATE INDEX IDX_C53D045FC297FC36 ON image (logo_site_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FB72964A');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FC297FC36');
        $this->addSql('ALTER TABLE project_site DROP FOREIGN KEY FK_50D2C1FCA76ED395');
        $this->addSql('DROP TABLE project_site');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F62E699E');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FDC2DBB8B');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FAB07C711');
        $this->addSql('DROP INDEX IDX_C53D045F62E699E ON image');
        $this->addSql('DROP INDEX IDX_C53D045FDC2DBB8B ON image');
        $this->addSql('DROP INDEX IDX_C53D045FAB07C711 ON image');
        $this->addSql('DROP INDEX IDX_C53D045FB72964A ON image');
        $this->addSql('DROP INDEX IDX_C53D045FC297FC36 ON image');
        $this->addSql('ALTER TABLE image ADD goodproject_logo_id INT DEFAULT NULL, ADD project_reseaux_id INT DEFAULT NULL, DROP good_project_logo_id, DROP project_reseaux_logo_id, DROP example_id, DROP visuals_id, DROP logo_site_id');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA5B0A33 FOREIGN KEY (goodproject_logo_id) REFERENCES project_logo (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F2124502A FOREIGN KEY (project_reseaux_id) REFERENCES project_reseaux (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FA5B0A33 ON image (goodproject_logo_id)');
        $this->addSql('CREATE INDEX IDX_C53D045F2124502A ON image (project_reseaux_id)');
    }
}
