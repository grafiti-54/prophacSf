<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220326131356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE FULLTEXT INDEX IDX_475BBDDA6C6E55B56DE44026 ON produits (nom, description)');
        $this->addSql('ALTER TABLE produits RENAME INDEX idx_be2ddf8c98de13ac TO IDX_475BBDDA98DE13AC');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles CHANGE titre titre VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contenu contenu LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE illustration illustration VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE titre_illustration titre_illustration VARCHAR(150) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE legende_illustration legende_illustration VARCHAR(150) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE collaborateurs CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(55) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(55) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE photo photo VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE departements CHANGE nom nom VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE logo logo VARCHAR(150) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE images CHANGE titre titre VARCHAR(150) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lien lien VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE legende legende VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE partenaires CHANGE nom nom VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE site_internet site_internet VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE logo logo VARCHAR(150) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX IDX_475BBDDA6C6E55B56DE44026 ON Produits');
        $this->addSql('ALTER TABLE Produits CHANGE nom nom VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE photo photo VARCHAR(150) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lien lien VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE Produits RENAME INDEX idx_475bbdda98de13ac TO IDX_BE2DDF8C98DE13AC');
        $this->addSql('ALTER TABLE qualifications CHANGE libelle libelle VARCHAR(80) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE telephones CHANGE numero numero VARCHAR(25) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
