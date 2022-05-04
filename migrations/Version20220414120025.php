<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414120025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Bagage (id INT AUTO_INCREMENT NOT NULL, id_userr INT DEFAULT NULL, poids VARCHAR(30) NOT NULL, poidsM VARCHAR(30) NOT NULL, poidsS VARCHAR(30) NOT NULL, dimension VARCHAR(30) NOT NULL, num_valise INT NOT NULL, INDEX id_userr (id_userr), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE FraisBagage (id INT AUTO_INCREMENT NOT NULL, poids VARCHAR(30) NOT NULL, dimension VARCHAR(30) NOT NULL, tarifs_base INT NOT NULL, tarifs_confort INT NOT NULL, montant INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE airport (id_aeroport INT AUTO_INCREMENT NOT NULL, nom_aeroport VARCHAR(500) NOT NULL, ville_aeroport VARCHAR(500) NOT NULL, pays VARCHAR(500) NOT NULL, PRIMARY KEY(id_aeroport)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (idArticle BIGINT AUTO_INCREMENT NOT NULL, titre VARCHAR(250) NOT NULL, contenu VARCHAR(500) NOT NULL, description VARCHAR(250) NOT NULL, imageURL VARCHAR(250) DEFAULT NULL, nbrLike INT NOT NULL, idUser INT DEFAULT NULL, INDEX IDX_23A0E66FE6E88D7 (idUser), PRIMARY KEY(idArticle)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avcom (id INT AUTO_INCREMENT NOT NULL, CodeCom VARCHAR(50) NOT NULL, NomC VARCHAR(50) NOT NULL, numbAvC INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avion (CodeAvion VARCHAR(50) NOT NULL, TypeA VARCHAR(50) NOT NULL, Model VARCHAR(50) NOT NULL, PassagerN DOUBLE PRECISION NOT NULL, CodeC VARCHAR(50) DEFAULT NULL, INDEX Fk_CA (CodeC), PRIMARY KEY(CodeAvion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis (id INT UNSIGNED AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, rating INT NOT NULL, commentaire VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, INDEX id_user (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compagnie (Code_IATA VARCHAR(50) NOT NULL, NomCom VARCHAR(50) NOT NULL, Link VARCHAR(50) NOT NULL, Pays VARCHAR(50) NOT NULL, Number INT NOT NULL, Siege VARCHAR(50) NOT NULL, AeBase VARCHAR(50) NOT NULL, PassagerNum DOUBLE PRECISION NOT NULL, Description TEXT NOT NULL, PRIMARY KEY(Code_IATA)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, nomDepartement VARCHAR(30) NOT NULL, zoneDepartement VARCHAR(30) NOT NULL, detailDepartement VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipements (id INT AUTO_INCREMENT NOT NULL, id_departement INT DEFAULT NULL, typeEquipement VARCHAR(30) NOT NULL, nomEquipement VARCHAR(30) NOT NULL, detailEquipement VARCHAR(30) NOT NULL, zoneEquipement VARCHAR(30) NOT NULL, etatEquipement VARCHAR(30) NOT NULL, INDEX fk (id_departement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE escale (id_escale INT AUTO_INCREMENT NOT NULL, aeroport_depart INT DEFAULT NULL, aeroport_destination INT DEFAULT NULL, heureArriveEscale VARCHAR(50) NOT NULL, heureDepartEscale VARCHAR(50) NOT NULL, durée VARCHAR(50) NOT NULL, INDEX escale1 (aeroport_depart), INDEX escale2 (aeroport_destination), PRIMARY KEY(id_escale)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(250) NOT NULL, tel INT NOT NULL, type VARCHAR(100) NOT NULL, nbr INT NOT NULL, etat VARCHAR(100) NOT NULL, description VARCHAR(10000) NOT NULL, date_reclamation DATE NOT NULL, INDEX id_user (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, email VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, num_tel INT NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vols (id_vol INT AUTO_INCREMENT NOT NULL, type_avion VARCHAR(50) DEFAULT NULL, id_aeroport INT DEFAULT NULL, id_escale INT DEFAULT NULL, id_comp VARCHAR(50) DEFAULT NULL, num_vol INT NOT NULL, date_depart_vol VARCHAR(200) NOT NULL, date_arrivé_vol VARCHAR(200) NOT NULL, heure_depart_vol VARCHAR(200) NOT NULL, heure_arrivé_vol VARCHAR(200) NOT NULL, type_vol VARCHAR(200) NOT NULL, nombrePassager_vol INT NOT NULL, durée_retard_vol VARCHAR(100) NOT NULL, annulation_vol TINYINT(1) NOT NULL, INDEX vol2 (id_comp), INDEX vol3 (id_escale), INDEX vol4 (type_avion), INDEX vol1 (id_aeroport), UNIQUE INDEX num_vol (num_vol), PRIMARY KEY(id_vol)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Bagage ADD CONSTRAINT FK_AF8052238D01D44F FOREIGN KEY (id_userr) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE avion ADD CONSTRAINT FK_234D9D382B5DEE5 FOREIGN KEY (CodeC) REFERENCES compagnie (Code_IATA)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF06B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE equipements ADD CONSTRAINT FK_3F02D86BD9649694 FOREIGN KEY (id_departement) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE escale ADD CONSTRAINT FK_C39FEDD3F3E6BCDC FOREIGN KEY (aeroport_depart) REFERENCES airport (id_aeroport)');
        $this->addSql('ALTER TABLE escale ADD CONSTRAINT FK_C39FEDD3CA59C2E6 FOREIGN KEY (aeroport_destination) REFERENCES airport (id_aeroport)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064046B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vols ADD CONSTRAINT FK_2CDFA86C2D411ACF FOREIGN KEY (type_avion) REFERENCES avion (CodeAvion)');
        $this->addSql('ALTER TABLE vols ADD CONSTRAINT FK_2CDFA86CCF6B3E1D FOREIGN KEY (id_aeroport) REFERENCES airport (id_aeroport)');
        $this->addSql('ALTER TABLE vols ADD CONSTRAINT FK_2CDFA86CE5A8583E FOREIGN KEY (id_escale) REFERENCES escale (id_escale)');
        $this->addSql('ALTER TABLE vols ADD CONSTRAINT FK_2CDFA86C402A7338 FOREIGN KEY (id_comp) REFERENCES compagnie (Code_IATA)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE escale DROP FOREIGN KEY FK_C39FEDD3F3E6BCDC');
        $this->addSql('ALTER TABLE escale DROP FOREIGN KEY FK_C39FEDD3CA59C2E6');
        $this->addSql('ALTER TABLE vols DROP FOREIGN KEY FK_2CDFA86CCF6B3E1D');
        $this->addSql('ALTER TABLE vols DROP FOREIGN KEY FK_2CDFA86C2D411ACF');
        $this->addSql('ALTER TABLE avion DROP FOREIGN KEY FK_234D9D382B5DEE5');
        $this->addSql('ALTER TABLE vols DROP FOREIGN KEY FK_2CDFA86C402A7338');
        $this->addSql('ALTER TABLE equipements DROP FOREIGN KEY FK_3F02D86BD9649694');
        $this->addSql('ALTER TABLE vols DROP FOREIGN KEY FK_2CDFA86CE5A8583E');
        $this->addSql('ALTER TABLE Bagage DROP FOREIGN KEY FK_AF8052238D01D44F');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66FE6E88D7');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF06B3CA4B');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064046B3CA4B');
        $this->addSql('DROP TABLE Bagage');
        $this->addSql('DROP TABLE FraisBagage');
        $this->addSql('DROP TABLE airport');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE avcom');
        $this->addSql('DROP TABLE avion');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE compagnie');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE equipements');
        $this->addSql('DROP TABLE escale');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vols');
    }
}
