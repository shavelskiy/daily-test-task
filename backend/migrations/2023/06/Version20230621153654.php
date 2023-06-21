<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230621153654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE record ADD files_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE record ADD CONSTRAINT FK_9B349F91A3E65B2F FOREIGN KEY (files_id) REFERENCES file (id)');
        $this->addSql('CREATE INDEX IDX_9B349F91A3E65B2F ON record (files_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE record DROP FOREIGN KEY FK_9B349F91A3E65B2F');
        $this->addSql('DROP INDEX IDX_9B349F91A3E65B2F ON record');
        $this->addSql('ALTER TABLE record DROP files_id');
    }
}
