<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241111203122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pause_reprise CHANGE lat lat NUMERIC(9, 6) DEFAULT NULL, CHANGE lon lon NUMERIC(9, 6) DEFAULT NULL');
        $this->addSql('ALTER TABLE points_map CHANGE lat lat NUMERIC(9, 6) NOT NULL, CHANGE lon lon NUMERIC(9, 6) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE points_map CHANGE lat lat NUMERIC(9, 6) DEFAULT NULL, CHANGE lon lon NUMERIC(9, 6) DEFAULT NULL');
        $this->addSql('ALTER TABLE pause_reprise CHANGE lat lat NUMERIC(3, 3) DEFAULT NULL, CHANGE lon lon NUMERIC(3, 3) DEFAULT NULL');
    }
}
