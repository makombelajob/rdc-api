<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251022154700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrative (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, principal_town VARCHAR(255) NOT NULL, surface VARCHAR(50) NOT NULL, population VARCHAR(50) NOT NULL, latitude NUMERIC(10, 8) DEFAULT NULL, longitude NUMERIC(11, 8) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE airport (id INT AUTO_INCREMENT NOT NULL, province_id INT DEFAULT NULL, sce_sem VARCHAR(255) DEFAULT NULL, sce_geo VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, origine VARCHAR(255) DEFAULT NULL, name_primary VARCHAR(255) DEFAULT NULL, name_secondary VARCHAR(255) DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, covering VARCHAR(255) DEFAULT NULL, airport_usage VARCHAR(255) DEFAULT NULL, longitude NUMERIC(11, 8) DEFAULT NULL, latitude NUMERIC(10, 8) DEFAULT NULL, length INT DEFAULT NULL, width INT DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, altitude INT DEFAULT NULL, practicable VARCHAR(10) DEFAULT NULL, INDEX IDX_7E91F7C2E946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, province_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2D5B0234E946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE port (id INT AUTO_INCREMENT NOT NULL, province_entity_id INT DEFAULT NULL, sce_sem VARCHAR(255) DEFAULT NULL, sce_geo VARCHAR(255) DEFAULT NULL, origine VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, province VARCHAR(255) DEFAULT NULL, administrative VARCHAR(255) DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, code_grpt VARCHAR(255) DEFAULT NULL, INDEX IDX_43915DCCA147761 (province_entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE province (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, principal_town VARCHAR(255) NOT NULL, surface VARCHAR(255) NOT NULL, population VARCHAR(255) NOT NULL, latitude NUMERIC(10, 8) DEFAULT NULL, longitude NUMERIC(11, 8) DEFAULT NULL, pcode_province VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE railway_station (id INT AUTO_INCREMENT NOT NULL, province_entity_id INT DEFAULT NULL, sce_sem VARCHAR(255) DEFAULT NULL, sce_geo VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, origine VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, province VARCHAR(255) DEFAULT NULL, district VARCHAR(255) DEFAULT NULL, breakdown TINYINT(1) DEFAULT NULL, store VARCHAR(255) DEFAULT NULL, atelier INT DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, INDEX IDX_F78A6CAFA147761 (province_entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE territoire (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone_sante (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE airport ADD CONSTRAINT FK_7E91F7C2E946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234E946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE port ADD CONSTRAINT FK_43915DCCA147761 FOREIGN KEY (province_entity_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE railway_station ADD CONSTRAINT FK_F78A6CAFA147761 FOREIGN KEY (province_entity_id) REFERENCES province (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE airport DROP FOREIGN KEY FK_7E91F7C2E946114A');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234E946114A');
        $this->addSql('ALTER TABLE port DROP FOREIGN KEY FK_43915DCCA147761');
        $this->addSql('ALTER TABLE railway_station DROP FOREIGN KEY FK_F78A6CAFA147761');
        $this->addSql('DROP TABLE administrative');
        $this->addSql('DROP TABLE airport');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE port');
        $this->addSql('DROP TABLE province');
        $this->addSql('DROP TABLE railway_station');
        $this->addSql('DROP TABLE territoire');
        $this->addSql('DROP TABLE zone_sante');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
