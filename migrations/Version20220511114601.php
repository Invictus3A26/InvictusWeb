<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511114601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Bagage DROP FOREIGN KEY FK_AF8052238D01D44F');
        $this->addSql('ALTER TABLE Bagage ADD poids_m VARCHAR(255) NOT NULL, ADD poids_s VARCHAR(255) NOT NULL, DROP poidsM, DROP poidsS, CHANGE poids poids VARCHAR(255) DEFAULT NULL, CHANGE dimension dimension VARCHAR(255) NOT NULL, CHANGE num_valise num_valise INT DEFAULT NULL');
        $this->addSql('CREATE FULLTEXT INDEX IDX_AF805223D32E8E0DCA9BC19C ON Bagage (poids, dimension)');
        $this->addSql('DROP INDEX id_userr ON Bagage');
        $this->addSql('CREATE INDEX IDX_AF8052238D01D44F ON Bagage (id_userr)');
        $this->addSql('ALTER TABLE Bagage ADD CONSTRAINT FK_AF8052238D01D44F FOREIGN KEY (id_userr) REFERENCES user (id)');
        $this->addSql('ALTER TABLE FraisBagage ADD bagage_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE FraisBagage ADD CONSTRAINT FK_E0B820A411DBEE66 FOREIGN KEY (bagage_id_id) REFERENCES Bagage (id)');
        $this->addSql('CREATE INDEX IDX_E0B820A411DBEE66 ON FraisBagage (bagage_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_AF805223D32E8E0DCA9BC19C ON Bagage');
        $this->addSql('ALTER TABLE Bagage DROP FOREIGN KEY FK_AF8052238D01D44F');
        $this->addSql('ALTER TABLE Bagage ADD poidsM VARCHAR(30) NOT NULL, ADD poidsS VARCHAR(30) NOT NULL, DROP poids_m, DROP poids_s, CHANGE poids poids VARCHAR(30) NOT NULL, CHANGE dimension dimension VARCHAR(30) NOT NULL, CHANGE num_valise num_valise INT NOT NULL');
        $this->addSql('DROP INDEX idx_af8052238d01d44f ON Bagage');
        $this->addSql('CREATE INDEX id_userr ON Bagage (id_userr)');
        $this->addSql('ALTER TABLE Bagage ADD CONSTRAINT FK_AF8052238D01D44F FOREIGN KEY (id_userr) REFERENCES user (id)');
        $this->addSql('ALTER TABLE FraisBagage DROP FOREIGN KEY FK_E0B820A411DBEE66');
        $this->addSql('DROP INDEX IDX_E0B820A411DBEE66 ON FraisBagage');
        $this->addSql('ALTER TABLE FraisBagage DROP bagage_id_id');
    }
}
