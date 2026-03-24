<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260324144151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY `FK_4DB9D91C69CCBE9A`');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY `FK_4DB9D91C86DE015C`');
        $this->addSql('DROP INDEX IDX_4DB9D91C69CCBE9A ON announcement');
        $this->addSql('DROP INDEX IDX_4DB9D91C86DE015C ON announcement');
        $this->addSql('ALTER TABLE announcement ADD author_id INT DEFAULT NULL, ADD interested_user_id INT NOT NULL, DROP author_id_id, DROP interested_user_id_id');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91CB54B2A53 FOREIGN KEY (interested_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4DB9D91CF675F31B ON announcement (author_id)');
        $this->addSql('CREATE INDEX IDX_4DB9D91CB54B2A53 ON announcement (interested_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91CF675F31B');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91CB54B2A53');
        $this->addSql('DROP INDEX IDX_4DB9D91CF675F31B ON announcement');
        $this->addSql('DROP INDEX IDX_4DB9D91CB54B2A53 ON announcement');
        $this->addSql('ALTER TABLE announcement ADD interested_user_id_id INT NOT NULL, DROP author_id, CHANGE interested_user_id author_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT `FK_4DB9D91C69CCBE9A` FOREIGN KEY (author_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT `FK_4DB9D91C86DE015C` FOREIGN KEY (interested_user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4DB9D91C69CCBE9A ON announcement (author_id_id)');
        $this->addSql('CREATE INDEX IDX_4DB9D91C86DE015C ON announcement (interested_user_id_id)');
    }
}
