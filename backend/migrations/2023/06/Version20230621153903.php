<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230621153903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE record_file (record_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', file_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_6928A7C44DFD750C (record_id), INDEX IDX_6928A7C493CB796C (file_id), PRIMARY KEY(record_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE record_file ADD CONSTRAINT FK_6928A7C44DFD750C FOREIGN KEY (record_id) REFERENCES record (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE record_file ADD CONSTRAINT FK_6928A7C493CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE record DROP FOREIGN KEY FK_9B349F91A3E65B2F');
        $this->addSql('DROP INDEX IDX_9B349F91A3E65B2F ON record');
        $this->addSql('ALTER TABLE record DROP files_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE record_file DROP FOREIGN KEY FK_6928A7C44DFD750C');
        $this->addSql('ALTER TABLE record_file DROP FOREIGN KEY FK_6928A7C493CB796C');
        $this->addSql('DROP TABLE record_file');
        $this->addSql('ALTER TABLE record ADD files_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE record ADD CONSTRAINT FK_9B349F91A3E65B2F FOREIGN KEY (files_id) REFERENCES file (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9B349F91A3E65B2F ON record (files_id)');
    }
}
