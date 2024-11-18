<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241028185636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parcours DROP FOREIGN KEY FK_99B1DEE34A858D66');
        $this->addSql('ALTER TABLE parcours ADD users_id INT DEFAULT NULL, ADD status TINYINT(1) NOT NULL, ADD date_creation DATETIME NOT NULL, ADD date_modification DATETIME NOT NULL, DROP cree_par');
        $this->addSql('ALTER TABLE parcours ADD CONSTRAINT FK_99B1DEE367B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_99B1DEE367B3B43D ON parcours (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parcours DROP FOREIGN KEY FK_99B1DEE367B3B43D');
        $this->addSql('DROP INDEX IDX_99B1DEE367B3B43D ON parcours');
        $this->addSql('ALTER TABLE parcours ADD cree_par VARCHAR(50) NOT NULL, DROP users_id, DROP status, DROP date_creation, DROP date_modification');
    }
}
