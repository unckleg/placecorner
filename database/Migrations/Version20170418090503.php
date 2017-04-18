<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170418090503 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("
          CREATE TABLE IF NOT EXISTS `user` (
              `id` int(11) NOT NULL,
              `username` varchar(180) NOT NULL,
              `email` varchar(180) NOT NULL,
              `password` varchar(255) NOT NULL,
              `username_canonical` varchar(180) NOT NULL,
              `email_canonical` varchar(180) NOT NULL,
              `enabled` tinyint(1) NOT NULL,
              `salt` varchar(255) DEFAULT NULL,
              `last_login` datetime DEFAULT NULL,
              `confirmation_token` varchar(180) DEFAULT NULL,
              `password_requested_at` datetime DEFAULT NULL,
              `roles` longtext NOT NULL COMMENT '(DC2Type:array)'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
          
          ALTER TABLE `user`
          ADD PRIMARY KEY (`id`),
          ADD UNIQUE KEY `email_UNIQUE` (`email`),
          ADD UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
          ADD UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
          ADD UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`);");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE user");

    }
}
