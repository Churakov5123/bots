<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221120142609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coincidence_activity (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', choose_profile_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', chosen_profile VARCHAR(255) NOT NULL, is_like TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_732C8F841CC40A20 (choose_profile_id), INDEX IDX_732C8F848B8E8428 (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistic (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', fake_count INT NOT NULL, real_count INT NOT NULL, match_count INT NOT NULL, today_real_count INT NOT NULL, today_fake_count INT NOT NULL, today_match_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coincidence_activity ADD CONSTRAINT FK_732C8F841CC40A20 FOREIGN KEY (choose_profile_id) REFERENCES profile (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE coincidence_activity');
        $this->addSql('DROP TABLE statistic');
    }
}
