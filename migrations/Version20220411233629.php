<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220411233629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bagage (id INT AUTO_INCREMENT NOT NULL, poids VARCHAR(255) DEFAULT NULL, poids_m VARCHAR(255) NOT NULL, poids_s VARCHAR(255) NOT NULL, dimension VARCHAR(255) NOT NULL, num_valise INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fraisbagage (id INT AUTO_INCREMENT NOT NULL, poids VARCHAR(255) NOT NULL, dimension VARCHAR(255) NOT NULL, tarifs_base INT NOT NULL, tarifs_confort INT NOT NULL, montant INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bagage');
        $this->addSql('DROP TABLE fraisbagage');
    }
}
