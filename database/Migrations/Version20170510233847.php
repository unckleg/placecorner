<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170510233847 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE place_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(1000) NOT NULL, content LONGTEXT DEFAULT NULL, seo_title VARCHAR(500) NOT NULL, seo_description VARCHAR(1000) DEFAULT NULL, seo_keywords VARCHAR(1000) DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_BA9C0DCB2C2AC5D3 (translatable_id), UNIQUE INDEX place_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, user_type INT NOT NULL, user_id INT NOT NULL, country_id INT NOT NULL, region_id INT NOT NULL, city_id INT NOT NULL, municipality_id INT DEFAULT NULL, gallery_id INT DEFAULT NULL, map VARCHAR(500) NOT NULL, working_hours LONGTEXT NOT NULL, address VARCHAR(500) NOT NULL, phone VARCHAR(45) NOT NULL, email VARCHAR(255) NOT NULL, website VARCHAR(100) DEFAULT NULL, views INT NOT NULL, social_facebook VARCHAR(1000) DEFAULT NULL, social_youtube VARCHAR(1000) DEFAULT NULL, social_instagram VARCHAR(1000) DEFAULT NULL, social_twitter VARCHAR(1000) DEFAULT NULL, status INT NOT NULL, is_deleted TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE place_translation ADD CONSTRAINT FK_BA9C0DCB2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES place (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE place_translation DROP FOREIGN KEY FK_BA9C0DCB2C2AC5D3');
        $this->addSql('DROP TABLE place_translation');
        $this->addSql('DROP TABLE place');
    }
}
