<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170512094800 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE place_images (place_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_42D1B903DA6A219 (place_id), UNIQUE INDEX UNIQ_42D1B9033DA5256D (image_id), PRIMARY KEY(place_id, image_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE place_images ADD CONSTRAINT FK_42D1B903DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE place_images ADD CONSTRAINT FK_42D1B9033DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('ALTER TABLE images DROP place_id');
        $this->addSql('ALTER TABLE place CHANGE image image VARCHAR(1000) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE place_images');
        $this->addSql('ALTER TABLE images ADD place_id INT NOT NULL');
        $this->addSql('ALTER TABLE place CHANGE image image VARCHAR(1000) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
