<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017163525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commenter (id INT AUTO_INCREMENT NOT NULL, parcours_id INT DEFAULT NULL, user_id INT DEFAULT NULL, commentaire VARCHAR(100) DEFAULT NULL, INDEX IDX_AB751D0A6E38C0DB (parcours_id), INDEX IDX_AB751D0AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE difficulte (id INT AUTO_INCREMENT NOT NULL, libelle_difficulte VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcours (id INT AUTO_INCREMENT NOT NULL, type_de_parcours_id INT DEFAULT NULL, difficulte_id INT DEFAULT NULL, nom_parcours VARCHAR(50) NOT NULL, prive TINYINT(1) NOT NULL, cree_par VARCHAR(50) NOT NULL, exclusif TINYINT(1) NOT NULL, INDEX IDX_99B1DEE34A858D66 (type_de_parcours_id), INDEX IDX_99B1DEE3E6357589 (difficulte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pause_reprise (id INT AUTO_INCREMENT NOT NULL, date_debut_pause DATETIME DEFAULT NULL, date_fin_pause DATETIME DEFAULT NULL, lat NUMERIC(9,6) DEFAULT NULL, lon NUMERIC(9,6) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pauser (id INT AUTO_INCREMENT NOT NULL, pause_reprise_id INT DEFAULT NULL, realiser_id INT DEFAULT NULL, INDEX IDX_B265FBCACDC3879D (pause_reprise_id), INDEX IDX_B265FBCAAC274FA8 (realiser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE points_map (id INT AUTO_INCREMENT NOT NULL, type_de_points_id INT DEFAULT NULL, parcours_id INT DEFAULT NULL, lat NUMERIC(9,6) NOT NULL, lon NUMERIC(9,6) NOT NULL, details VARCHAR(100) DEFAULT NULL, INDEX IDX_53779626873E8F23 (type_de_points_id), INDEX IDX_537796266E38C0DB (parcours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realiser (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, parcours_id INT DEFAULT NULL, date_debut DATETIME DEFAULT NULL, date_fin DATETIME DEFAULT NULL, INDEX IDX_7BAB8D07A76ED395 (user_id), INDEX IDX_7BAB8D076E38C0DB (parcours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, libelle_role VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_de_parcours (id INT AUTO_INCREMENT NOT NULL, libelle_parcours VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_de_points (id INT AUTO_INCREMENT NOT NULL, libelle_type_point VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(50) NOT NULL, INDEX IDX_1483A5E9D60322AC (role_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commenter ADD CONSTRAINT FK_AB751D0A6E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id)');
        $this->addSql('ALTER TABLE commenter ADD CONSTRAINT FK_AB751D0AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE parcours ADD CONSTRAINT FK_99B1DEE34A858D66 FOREIGN KEY (type_de_parcours_id) REFERENCES type_de_parcours (id)');
        $this->addSql('ALTER TABLE parcours ADD CONSTRAINT FK_99B1DEE3E6357589 FOREIGN KEY (difficulte_id) REFERENCES difficulte (id)');
        $this->addSql('ALTER TABLE pauser ADD CONSTRAINT FK_B265FBCACDC3879D FOREIGN KEY (pause_reprise_id) REFERENCES pause_reprise (id)');
        $this->addSql('ALTER TABLE pauser ADD CONSTRAINT FK_B265FBCAAC274FA8 FOREIGN KEY (realiser_id) REFERENCES realiser (id)');
        $this->addSql('ALTER TABLE points_map ADD CONSTRAINT FK_53779626873E8F23 FOREIGN KEY (type_de_points_id) REFERENCES type_de_points (id)');
        $this->addSql('ALTER TABLE points_map ADD CONSTRAINT FK_537796266E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id)');
        $this->addSql('ALTER TABLE realiser ADD CONSTRAINT FK_7BAB8D07A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE realiser ADD CONSTRAINT FK_7BAB8D076E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commenter DROP FOREIGN KEY FK_AB751D0A6E38C0DB');
        $this->addSql('ALTER TABLE commenter DROP FOREIGN KEY FK_AB751D0AA76ED395');
        $this->addSql('ALTER TABLE parcours DROP FOREIGN KEY FK_99B1DEE34A858D66');
        $this->addSql('ALTER TABLE parcours DROP FOREIGN KEY FK_99B1DEE3E6357589');
        $this->addSql('ALTER TABLE pauser DROP FOREIGN KEY FK_B265FBCACDC3879D');
        $this->addSql('ALTER TABLE pauser DROP FOREIGN KEY FK_B265FBCAAC274FA8');
        $this->addSql('ALTER TABLE points_map DROP FOREIGN KEY FK_53779626873E8F23');
        $this->addSql('ALTER TABLE points_map DROP FOREIGN KEY FK_537796266E38C0DB');
        $this->addSql('ALTER TABLE realiser DROP FOREIGN KEY FK_7BAB8D07A76ED395');
        $this->addSql('ALTER TABLE realiser DROP FOREIGN KEY FK_7BAB8D076E38C0DB');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9D60322AC');
        $this->addSql('DROP TABLE commenter');
        $this->addSql('DROP TABLE difficulte');
        $this->addSql('DROP TABLE parcours');
        $this->addSql('DROP TABLE pause_reprise');
        $this->addSql('DROP TABLE pauser');
        $this->addSql('DROP TABLE points_map');
        $this->addSql('DROP TABLE realiser');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE type_de_parcours');
        $this->addSql('DROP TABLE type_de_points');
        $this->addSql('DROP TABLE users');
    }
}
