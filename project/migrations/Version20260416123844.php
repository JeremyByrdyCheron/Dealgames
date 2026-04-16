<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260416123844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE announcement_user (interested_user_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A1A2DE15B54B2A53 (interested_user_id), INDEX IDX_A1A2DE15A76ED395 (user_id), PRIMARY KEY (interested_user_id, user_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE announcement_user ADD CONSTRAINT FK_A1A2DE15B54B2A53 FOREIGN KEY (interested_user_id) REFERENCES announcement (id)');
        $this->addSql('ALTER TABLE announcement_user ADD CONSTRAINT FK_A1A2DE15A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY `FK_4DB9D91CB54B2A53`');
        $this->addSql('DROP INDEX IDX_4DB9D91CB54B2A53 ON announcement');
        $this->addSql('ALTER TABLE announcement DROP interested_user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement_user DROP FOREIGN KEY FK_A1A2DE15B54B2A53');
        $this->addSql('ALTER TABLE announcement_user DROP FOREIGN KEY FK_A1A2DE15A76ED395');
        $this->addSql('DROP TABLE announcement_user');
        $this->addSql('ALTER TABLE announcement ADD interested_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT `FK_4DB9D91CB54B2A53` FOREIGN KEY (interested_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4DB9D91CB54B2A53 ON announcement (interested_user_id)');
    }
}
