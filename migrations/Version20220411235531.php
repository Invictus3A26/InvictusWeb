<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220411235531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avion (id INT AUTO_INCREMENT NOT NULL, code_c_id INT NOT NULL, CodeAvion VARCHAR(50) NOT NULL, TypeA VARCHAR(50) NOT NULL, Model VARCHAR(50) NOT NULL, PassagerN INT NOT NULL, INDEX IDX_234D9D38A73CF112 (code_c_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avion ADD CONSTRAINT FK_234D9D38A73CF112 FOREIGN KEY (code_c_id) REFERENCES compagnie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE avion');
    }
}
