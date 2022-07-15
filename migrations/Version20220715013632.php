<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220715013632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profile (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', login VARCHAR(64) NOT NULL, name VARCHAR(150) NOT NULL, birth_date DATETIME NOT NULL, country_code VARCHAR(2) NOT NULL, city VARCHAR(255) NOT NULL, gender SMALLINT NOT NULL, platform SMALLINT NOT NULL, couple SMALLINT NOT NULL, zodiac SMALLINT NOT NULL, matching_zodiacs LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', tags LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', description LONGTEXT DEFAULT NULL, media LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', locale VARCHAR(5) NOT NULL, lang VARCHAR(2) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8157AA0FAA08CB10 (login), INDEX IDX_8157AA0F1B5771DD (is_active), INDEX IDX_8157AA0F8B8E8428 (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
