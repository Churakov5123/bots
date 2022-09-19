<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220904075940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', profile_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_C53D045FCCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', login VARCHAR(64) NOT NULL, name VARCHAR(150) NOT NULL, birth_date DATETIME NOT NULL, age INT NOT NULL, search_age_diapazone JSON NOT NULL, country_code VARCHAR(2) NOT NULL, city VARCHAR(255) NOT NULL, gender SMALLINT NOT NULL, platform SMALLINT NOT NULL, couple SMALLINT NOT NULL, search_mode SMALLINT NOT NULL, astrology_horoscope SMALLINT NOT NULL, chinese_horoscope SMALLINT NOT NULL, tag INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, hobby SMALLINT DEFAULT NULL, locale VARCHAR(5) NOT NULL, lang VARCHAR(2) NOT NULL, is_active TINYINT(1) NOT NULL, last_activity DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8157AA0FAA08CB10 (login), INDEX IDX_8157AA0FAA08CB10 (login), INDEX IDX_8157AA0F1B5771DD (is_active), INDEX IDX_8157AA0F2D5B0234 (city), INDEX IDX_8157AA0FF026BB7C (country_code), INDEX IDX_8157AA0FA8FD092A (astrology_horoscope), INDEX IDX_8157AA0F53F4F5C4 (chinese_horoscope), INDEX IDX_8157AA0FA13010B2 (age), INDEX IDX_8157AA0F389B783 (tag), INDEX IDX_8157AA0FCCD052C2 (search_mode), INDEX IDX_8157AA0FD4154CC4 (last_activity), INDEX IDX_8157AA0F8B8E8428 (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FCCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FCCFA12B8');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
