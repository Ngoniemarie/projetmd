<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210628080635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE announce (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price INT NOT NULL, address VARCHAR(255) NOT NULL, cover_image VARCHAR(255) NOT NULL, rooms INT NOT NULL, is_available TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, announce_id INT DEFAULT NULL, author VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9474526C6F5DA3DE (announce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, announce_id INT DEFAULT NULL, url_image VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_C53D045F6F5DA3DE (announce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C6F5DA3DE FOREIGN KEY (announce_id) REFERENCES announce (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F6F5DA3DE FOREIGN KEY (announce_id) REFERENCES announce (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C6F5DA3DE');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F6F5DA3DE');
        $this->addSql('DROP TABLE announce');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE image');
    }
}
