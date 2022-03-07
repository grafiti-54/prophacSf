<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307090502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE departements (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, logo VARCHAR(150) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departements_collaborateurs (departements_id INT NOT NULL, collaborateurs_id INT NOT NULL, INDEX IDX_8724BC7C1DB279A6 (departements_id), INDEX IDX_8724BC7C5BBF76DC (collaborateurs_id), PRIMARY KEY(departements_id, collaborateurs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telephones (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE departements_collaborateurs ADD CONSTRAINT FK_8724BC7C1DB279A6 FOREIGN KEY (departements_id) REFERENCES departements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE departements_collaborateurs ADD CONSTRAINT FK_8724BC7C5BBF76DC FOREIGN KEY (collaborateurs_id) REFERENCES collaborateurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE collaborateurs ADD numero_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE collaborateurs ADD CONSTRAINT FK_4A340D95D172A78 FOREIGN KEY (numero_id) REFERENCES telephones (id)');
        $this->addSql('CREATE INDEX IDX_4A340D95D172A78 ON collaborateurs (numero_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departements_collaborateurs DROP FOREIGN KEY FK_8724BC7C1DB279A6');
        $this->addSql('ALTER TABLE collaborateurs DROP FOREIGN KEY FK_4A340D95D172A78');
        $this->addSql('DROP TABLE departements');
        $this->addSql('DROP TABLE departements_collaborateurs');
        $this->addSql('DROP TABLE telephones');
        $this->addSql('DROP INDEX IDX_4A340D95D172A78 ON collaborateurs');
        $this->addSql('ALTER TABLE collaborateurs DROP numero_id, CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(55) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(55) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE photo photo VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE qualifications CHANGE libelle libelle VARCHAR(80) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
