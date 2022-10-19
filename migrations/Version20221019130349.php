<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221019130349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis ADD adresse_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, ADD siret VARCHAR(30) DEFAULT NULL');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_8B27C52B4DE7DC5C ON devis (adresse_id)');
        $this->addSql('CREATE INDEX IDX_8B27C52BA76ED395 ON devis (user_id)');
        $this->addSql('ALTER TABLE image ADD devis_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F41DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F41DEFADA ON image (devis_id)');
        $this->addSql('ALTER TABLE project ADD type VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_logo ADD type VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_reseaux ADD type VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_site ADD type VARCHAR(15) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B4DE7DC5C');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52BA76ED395');
        $this->addSql('DROP INDEX IDX_8B27C52B4DE7DC5C ON devis');
        $this->addSql('DROP INDEX IDX_8B27C52BA76ED395 ON devis');
        $this->addSql('ALTER TABLE devis DROP adresse_id, DROP user_id, DROP siret');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F41DEFADA');
        $this->addSql('DROP INDEX IDX_C53D045F41DEFADA ON image');
        $this->addSql('ALTER TABLE image DROP devis_id');
        $this->addSql('ALTER TABLE project DROP type');
        $this->addSql('ALTER TABLE project_logo DROP type');
        $this->addSql('ALTER TABLE project_reseaux DROP type');
        $this->addSql('ALTER TABLE project_site DROP type');
    }
}
