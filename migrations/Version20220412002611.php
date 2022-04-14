<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412002611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fraisbagage ADD bagage_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE fraisbagage ADD CONSTRAINT FK_6188AA4511DBEE66 FOREIGN KEY (bagage_id_id) REFERENCES bagage (id)');
        $this->addSql('CREATE INDEX IDX_6188AA4511DBEE66 ON fraisbagage (bagage_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fraisbagage DROP FOREIGN KEY FK_6188AA4511DBEE66');
        $this->addSql('DROP INDEX IDX_6188AA4511DBEE66 ON fraisbagage');
        $this->addSql('ALTER TABLE fraisbagage DROP bagage_id_id');
    }
}
