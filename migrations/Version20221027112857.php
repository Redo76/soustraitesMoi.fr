<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221027112857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis ADD projet_libre_id INT DEFAULT NULL, ADD projet_logo_id INT DEFAULT NULL, ADD projet_reseaux_id INT DEFAULT NULL, ADD projet_site_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B881E0EB1 FOREIGN KEY (projet_libre_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B7BA5493B FOREIGN KEY (projet_logo_id) REFERENCES project_logo (id)');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52BB81FC332 FOREIGN KEY (projet_reseaux_id) REFERENCES project_reseaux (id)');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B74974B37 FOREIGN KEY (projet_site_id) REFERENCES project_site (id)');
        $this->addSql('CREATE INDEX IDX_8B27C52B881E0EB1 ON devis (projet_libre_id)');
        $this->addSql('CREATE INDEX IDX_8B27C52B7BA5493B ON devis (projet_logo_id)');
        $this->addSql('CREATE INDEX IDX_8B27C52BB81FC332 ON devis (projet_reseaux_id)');
        $this->addSql('CREATE INDEX IDX_8B27C52B74974B37 ON devis (projet_site_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B881E0EB1');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B7BA5493B');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52BB81FC332');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B74974B37');
        $this->addSql('DROP INDEX IDX_8B27C52B881E0EB1 ON devis');
        $this->addSql('DROP INDEX IDX_8B27C52B7BA5493B ON devis');
        $this->addSql('DROP INDEX IDX_8B27C52BB81FC332 ON devis');
        $this->addSql('DROP INDEX IDX_8B27C52B74974B37 ON devis');
        $this->addSql('ALTER TABLE devis DROP projet_libre_id, DROP projet_logo_id, DROP projet_reseaux_id, DROP projet_site_id');
    }
}
