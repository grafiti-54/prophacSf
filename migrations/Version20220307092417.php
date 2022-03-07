<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307092417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partenaires (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, site_internet VARCHAR(255) DEFAULT NULL, logo VARCHAR(150) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaires_departements (partenaires_id INT NOT NULL, departements_id INT NOT NULL, INDEX IDX_A32155CA38898CF5 (partenaires_id), INDEX IDX_A32155CA1DB279A6 (departements_id), PRIMARY KEY(partenaires_id, departements_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT DEFAULT NULL, nom VARCHAR(150) NOT NULL, description LONGTEXT DEFAULT NULL, photo VARCHAR(150) NOT NULL, INDEX IDX_BE2DDF8C98DE13AC (partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits_departements (produits_id INT NOT NULL, departements_id INT NOT NULL, INDEX IDX_5CE0A430CD11A2CF (produits_id), INDEX IDX_5CE0A4301DB279A6 (departements_id), PRIMARY KEY(produits_id, departements_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partenaires_departements ADD CONSTRAINT FK_A32155CA38898CF5 FOREIGN KEY (partenaires_id) REFERENCES partenaires (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partenaires_departements ADD CONSTRAINT FK_A32155CA1DB279A6 FOREIGN KEY (departements_id) REFERENCES departements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C98DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaires (id)');
        $this->addSql('ALTER TABLE produits_departements ADD CONSTRAINT FK_5CE0A430CD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produits_departements ADD CONSTRAINT FK_5CE0A4301DB279A6 FOREIGN KEY (departements_id) REFERENCES departements (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaires_departements DROP FOREIGN KEY FK_A32155CA38898CF5');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C98DE13AC');
        $this->addSql('ALTER TABLE produits_departements DROP FOREIGN KEY FK_5CE0A430CD11A2CF');
        $this->addSql('DROP TABLE partenaires');
        $this->addSql('DROP TABLE partenaires_departements');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE produits_departements');
        $this->addSql('ALTER TABLE collaborateurs CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(55) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(55) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE photo photo VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE departements CHANGE nom nom VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE logo logo VARCHAR(150) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE qualifications CHANGE libelle libelle VARCHAR(80) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE telephones CHANGE numero numero VARCHAR(25) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
