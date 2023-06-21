<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230621171340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auth_token DROP FOREIGN KEY FK_9315F04EA76ED395');
        $this->addSql('ALTER TABLE auth_token ADD CONSTRAINT FK_9315F04EA76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610A76ED395');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE record DROP FOREIGN KEY FK_9B349F91A76ED395');
        $this->addSql('ALTER TABLE record ADD CONSTRAINT FK_9B349F91A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610A76ED395');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE record DROP FOREIGN KEY FK_9B349F91A76ED395');
        $this->addSql('ALTER TABLE record ADD CONSTRAINT FK_9B349F91A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE auth_token DROP FOREIGN KEY FK_9315F04EA76ED395');
        $this->addSql('ALTER TABLE auth_token ADD CONSTRAINT FK_9315F04EA76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
