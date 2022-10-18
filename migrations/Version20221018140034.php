<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018140034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE devis (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) DEFAULT NULL, date_redaction DATE DEFAULT NULL, duree_validite DATE DEFAULT NULL, detail LONGTEXT DEFAULT NULL, prix_ht INT DEFAULT NULL, prix_ttc INT DEFAULT NULL, raison_social VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE project_logo ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE brand_name nom_du_projet VARCHAR(75) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_reseaux ADD nom_du_projet VARCHAR(75) NOT NULL, ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP brand_name');
        $this->addSql('ALTER TABLE project_site ADD nom_du_projet VARCHAR(75) NOT NULL, ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE devis');
        $this->addSql('ALTER TABLE project DROP created_at');
        $this->addSql('ALTER TABLE project_logo DROP created_at, CHANGE nom_du_projet brand_name VARCHAR(75) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_reseaux ADD brand_name VARCHAR(75) DEFAULT NULL, DROP nom_du_projet, DROP created_at');
        $this->addSql('ALTER TABLE project_site DROP nom_du_projet, DROP created_at');
    }
}
