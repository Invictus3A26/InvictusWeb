<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511102037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE FULLTEXT INDEX IDX_C1765B63440372C25EEA4BB ON departement (zoneDepartement, nomDepartement)');
        $this->addSql('ALTER TABLE equipements ADD image_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user DROP role');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_C1765B63440372C25EEA4BB ON departement');
        $this->addSql('ALTER TABLE equipements DROP image_name');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(255) DEFAULT NULL');
    }
}
