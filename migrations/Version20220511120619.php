<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511120619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE FraisBagage DROP FOREIGN KEY FK_E0B820A411DBEE66');
        $this->addSql('ALTER TABLE FraisBagage CHANGE poids poids VARCHAR(255) NOT NULL, CHANGE dimension dimension VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX idx_e0b820a411dbee66 ON FraisBagage');
        $this->addSql('CREATE INDEX IDX_6188AA4511DBEE66 ON FraisBagage (bagage_id_id)');
        $this->addSql('ALTER TABLE FraisBagage ADD CONSTRAINT FK_E0B820A411DBEE66 FOREIGN KEY (bagage_id_id) REFERENCES Bagage (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fraisbagage DROP FOREIGN KEY FK_6188AA4511DBEE66');
        $this->addSql('ALTER TABLE fraisbagage CHANGE poids poids VARCHAR(30) NOT NULL, CHANGE dimension dimension VARCHAR(30) NOT NULL');
        $this->addSql('DROP INDEX idx_6188aa4511dbee66 ON fraisbagage');
        $this->addSql('CREATE INDEX IDX_E0B820A411DBEE66 ON fraisbagage (bagage_id_id)');
        $this->addSql('ALTER TABLE fraisbagage ADD CONSTRAINT FK_6188AA4511DBEE66 FOREIGN KEY (bagage_id_id) REFERENCES Bagage (id)');
    }
}
