<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190820150106 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE famille ADD head_family_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE famille ADD CONSTRAINT FK_2473F2134351DB49 FOREIGN KEY (head_family_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2473F2134351DB49 ON famille (head_family_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE famille DROP FOREIGN KEY FK_2473F2134351DB49');
        $this->addSql('DROP INDEX IDX_2473F2134351DB49 ON famille');
        $this->addSql('ALTER TABLE famille DROP head_family_id');
    }
}
