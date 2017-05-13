<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170512092956 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE images CHANGE gallery_id gallery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A4E7AF8F ON images (gallery_id)');
        $this->addSql('ALTER TABLE place ADD image VARCHAR(500) NOT NULL');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A4E7AF8F');
        $this->addSql('DROP INDEX IDX_E01FBE6A4E7AF8F ON images');
        $this->addSql('ALTER TABLE images CHANGE gallery_id gallery_id INT NOT NULL');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD4E7AF8F');
        $this->addSql('ALTER TABLE place DROP image');
    }
}
