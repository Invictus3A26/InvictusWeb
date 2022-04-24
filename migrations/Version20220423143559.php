<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220423143559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipements DROP FOREIGN KEY fk');
        $this->addSql('ALTER TABLE equipements ADD image_name VARCHAR(255) NOT NULL, CHANGE id_departement id_departement INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipements ADD CONSTRAINT FK_3F02D86BD9649694 FOREIGN KEY (id_departement) REFERENCES departement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipements DROP FOREIGN KEY FK_3F02D86BD9649694');
        $this->addSql('ALTER TABLE equipements DROP image_name, CHANGE id_departement id_departement INT NOT NULL');
        $this->addSql('ALTER TABLE equipements ADD CONSTRAINT fk FOREIGN KEY (id_departement) REFERENCES departement (id) ON DELETE CASCADE');
    }
}
