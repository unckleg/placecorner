<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170421125959 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post_translation DROP FOREIGN KEY FK_5829CF402C2AC5D3');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_translation');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, is_deleted TINYINT(1) NOT NULL, tags VARCHAR(500) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, content VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, image VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, locale VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX post_translation_unique_translation (translatable_id, locale), INDEX IDX_5829CF402C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_translation ADD CONSTRAINT FK_5829CF402C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES post (id) ON DELETE CASCADE');
    }
}
