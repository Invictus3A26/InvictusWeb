<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511151146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Bagage (id INT AUTO_INCREMENT NOT NULL, id_userr INT DEFAULT NULL, poids VARCHAR(255) DEFAULT NULL, poids_m VARCHAR(255) NOT NULL, poids_s VARCHAR(255) NOT NULL, dimension VARCHAR(255) NOT NULL, num_valise INT DEFAULT NULL, INDEX IDX_AF8052238D01D44F (id_userr), FULLTEXT INDEX IDX_AF805223D32E8E0DCA9BC19C (poids, dimension), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE airport (id_aeroport INT AUTO_INCREMENT NOT NULL, nom_aeroport VARCHAR(500) NOT NULL, ville_aeroport VARCHAR(500) NOT NULL, pays VARCHAR(500) NOT NULL, UNIQUE INDEX UNIQ_7E91F7C2AFA1701 (nom_aeroport), PRIMARY KEY(id_aeroport)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (idArticle BIGINT AUTO_INCREMENT NOT NULL, titre VARCHAR(250) NOT NULL, contenu VARCHAR(500) NOT NULL, description VARCHAR(250) NOT NULL, imageURL VARCHAR(250) DEFAULT NULL, nbrLike INT DEFAULT NULL, idUser INT DEFAULT NULL, INDEX IDX_23A0E66FE6E88D7 (idUser), PRIMARY KEY(idArticle)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, rating INT NOT NULL, commentaire VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, nomDepartement VARCHAR(30) NOT NULL, zoneDepartement VARCHAR(30) NOT NULL, detailDepartement VARCHAR(30) NOT NULL, FULLTEXT INDEX IDX_C1765B63440372C25EEA4BB (zoneDepartement, nomDepartement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipements (id INT AUTO_INCREMENT NOT NULL, id_departement INT DEFAULT NULL, typeEquipement VARCHAR(30) NOT NULL, nomEquipement VARCHAR(30) NOT NULL, detailEquipement VARCHAR(30) NOT NULL, zoneEquipement VARCHAR(30) NOT NULL, etatEquipement VARCHAR(30) NOT NULL, image_name VARCHAR(255) NOT NULL, INDEX fk (id_departement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE escale (id_escale INT AUTO_INCREMENT NOT NULL, aeroport_destination INT DEFAULT NULL, aeroport_depart INT DEFAULT NULL, heureArriveEscale VARCHAR(50) NOT NULL, heureDepartEscale VARCHAR(50) NOT NULL, duree VARCHAR(50) NOT NULL, INDEX aeroport_destination (aeroport_destination), INDEX aeroport_depart (aeroport_depart), PRIMARY KEY(id_escale)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fraisbagage (id INT AUTO_INCREMENT NOT NULL, bagage_id_id INT NOT NULL, poids VARCHAR(255) NOT NULL, dimension VARCHAR(255) NOT NULL, tarifs_base INT NOT NULL, tarifs_confort INT NOT NULL, montant INT NOT NULL, INDEX IDX_6188AA4511DBEE66 (bagage_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, compagnies_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C53D045F5F9EE3CE (compagnies_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tel INT NOT NULL, etat VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_reclamation DATE NOT NULL, INDEX IDX_CE606404C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, num_tel INT DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', username VARCHAR(255) DEFAULT NULL, activation_token VARCHAR(50) DEFAULT NULL, reset_token VARCHAR(60) DEFAULT NULL, disable_token VARCHAR(65) DEFAULT NULL, verification_code VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vols (id_vol INT AUTO_INCREMENT NOT NULL, id_comp INT DEFAULT NULL, type_avion INT DEFAULT NULL, id_aeroport INT DEFAULT NULL, id_escale INT DEFAULT NULL, num_vol INT NOT NULL, date_depart_vol VARCHAR(200) NOT NULL, date_arrive_vol VARCHAR(200) NOT NULL, heure_depart_vol VARCHAR(200) NOT NULL, heure_arrive_vol VARCHAR(200) NOT NULL, type_vol VARCHAR(200) NOT NULL, nombrePassager_vol INT NOT NULL, duree_retard_vol VARCHAR(100) NOT NULL, annulation_vol TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_2CDFA86C19DB9645 (num_vol), INDEX id_comp (id_comp), INDEX id_escale (id_escale), INDEX type_avion (type_avion), INDEX id_aeroport (id_aeroport), PRIMARY KEY(id_vol)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Bagage ADD CONSTRAINT FK_AF8052238D01D44F FOREIGN KEY (id_userr) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE equipements ADD CONSTRAINT FK_3F02D86BD9649694 FOREIGN KEY (id_departement) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE escale ADD CONSTRAINT FK_C39FEDD3CA59C2E6 FOREIGN KEY (aeroport_destination) REFERENCES airport (id_aeroport)');
        $this->addSql('ALTER TABLE escale ADD CONSTRAINT FK_C39FEDD3F3E6BCDC FOREIGN KEY (aeroport_depart) REFERENCES airport (id_aeroport)');
        $this->addSql('ALTER TABLE fraisbagage ADD CONSTRAINT FK_6188AA4511DBEE66 FOREIGN KEY (bagage_id_id) REFERENCES Bagage (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F5F9EE3CE FOREIGN KEY (compagnies_id) REFERENCES compagnie (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE vols ADD CONSTRAINT FK_2CDFA86C402A7338 FOREIGN KEY (id_comp) REFERENCES compagnie (id)');
        $this->addSql('ALTER TABLE vols ADD CONSTRAINT FK_2CDFA86C2D411ACF FOREIGN KEY (type_avion) REFERENCES avion (id)');
        $this->addSql('ALTER TABLE vols ADD CONSTRAINT FK_2CDFA86CCF6B3E1D FOREIGN KEY (id_aeroport) REFERENCES airport (id_aeroport)');
        $this->addSql('ALTER TABLE vols ADD CONSTRAINT FK_2CDFA86CE5A8583E FOREIGN KEY (id_escale) REFERENCES escale (id_escale)');
        $this->addSql('DROP TABLE avcom');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fraisbagage DROP FOREIGN KEY FK_6188AA4511DBEE66');
        $this->addSql('ALTER TABLE escale DROP FOREIGN KEY FK_C39FEDD3CA59C2E6');
        $this->addSql('ALTER TABLE escale DROP FOREIGN KEY FK_C39FEDD3F3E6BCDC');
        $this->addSql('ALTER TABLE vols DROP FOREIGN KEY FK_2CDFA86CCF6B3E1D');
        $this->addSql('ALTER TABLE equipements DROP FOREIGN KEY FK_3F02D86BD9649694');
        $this->addSql('ALTER TABLE vols DROP FOREIGN KEY FK_2CDFA86CE5A8583E');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404C54C8C93');
        $this->addSql('ALTER TABLE Bagage DROP FOREIGN KEY FK_AF8052238D01D44F');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66FE6E88D7');
        $this->addSql('CREATE TABLE avcom (id INT AUTO_INCREMENT NOT NULL, CodeCom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, NomC VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, numbAvC INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE Bagage');
        $this->addSql('DROP TABLE airport');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE equipements');
        $this->addSql('DROP TABLE escale');
        $this->addSql('DROP TABLE fraisbagage');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vols');
    }
}
