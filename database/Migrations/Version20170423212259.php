<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170423212259 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("
          CREATE TABLE `category` (
             `id` int(11) NOT NULL AUTO_INCREMENT,
             `parent_id` int(11) NOT NULL,
             `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
             `status` smallint(6) NOT NULL,
             `is_deleted` tinyint(1) NOT NULL,
             `order_number` int(11) NOT NULL,
             PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_translation');
    }
}
