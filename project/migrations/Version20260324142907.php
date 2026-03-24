<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260324142907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, inscription_date DATE NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('DROP TABLE role');
        $this->addSql('ALTER TABLE announcement ADD author_id_id INT NOT NULL, ADD interested_user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91C69CCBE9A FOREIGN KEY (author_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91C86DE015C FOREIGN KEY (interested_user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4DB9D91C69CCBE9A ON announcement (author_id_id)');
        $this->addSql('CREATE INDEX IDX_4DB9D91C86DE015C ON announcement (interested_user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91C69CCBE9A');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91C86DE015C');
        $this->addSql('DROP INDEX IDX_4DB9D91C69CCBE9A ON announcement');
        $this->addSql('DROP INDEX IDX_4DB9D91C86DE015C ON announcement');
        $this->addSql('ALTER TABLE announcement DROP author_id_id, DROP interested_user_id_id');
    }
}
