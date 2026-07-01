<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260701203718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title CLOB NOT NULL, url_title CLOB NOT NULL, created_date DATETIME NOT NULL, updated_date DATETIME NOT NULL, article_content_id INTEGER DEFAULT NULL, author_id INTEGER NOT NULL, CONSTRAINT FK_23A0E66B879726C FOREIGN KEY (article_content_id) REFERENCES article_content (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES writer (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66B879726C ON article (article_content_id)');
        $this->addSql('CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)');
        $this->addSql('CREATE TABLE article_content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('CREATE TABLE text_component (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content CLOB DEFAULT NULL, position INTEGER NOT NULL, size VARCHAR(255) NOT NULL, article_content_id INTEGER DEFAULT NULL, CONSTRAINT FK_BAF19293B879726C FOREIGN KEY (article_content_id) REFERENCES article_content (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BAF19293B879726C ON text_component (article_content_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image_component AS SELECT id, original_name, name, author_id, author_ip FROM image_component');
        $this->addSql('DROP TABLE image_component');
        $this->addSql('CREATE TABLE image_component (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, original_name CLOB NOT NULL, name CLOB DEFAULT NULL, author_id INTEGER NOT NULL, author_ip CLOB NOT NULL, article_content_id INTEGER DEFAULT NULL, CONSTRAINT FK_2C15FBB4F675F09E FOREIGN KEY (author_id) REFERENCES writer (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_917C7A03B879726C FOREIGN KEY (article_content_id) REFERENCES article_content (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO image_component (id, original_name, name, author_id, author_ip) SELECT id, original_name, name, author_id, author_ip FROM __temp__image_component');
        $this->addSql('DROP TABLE __temp__image_component');
        $this->addSql('CREATE INDEX IDX_917C7A03B879726C ON image_component (article_content_id)');
        $this->addSql('CREATE INDEX IDX_917C7A03F675F31B ON image_component (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_content');
        $this->addSql('DROP TABLE text_component');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image_component AS SELECT id, original_name, name, author_ip, author_id FROM image_component');
        $this->addSql('DROP TABLE image_component');
        $this->addSql('CREATE TABLE image_component (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, original_name CLOB NOT NULL, name CLOB DEFAULT NULL, author_ip CLOB NOT NULL, author_id INTEGER NOT NULL, CONSTRAINT FK_917C7A03F675F31B FOREIGN KEY (author_id) REFERENCES writer (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO image_component (id, original_name, name, author_ip, author_id) SELECT id, original_name, name, author_ip, author_id FROM __temp__image_component');
        $this->addSql('DROP TABLE __temp__image_component');
        $this->addSql('CREATE INDEX IDX_2C15FBB4F675F09E ON image_component (author_id)');
    }
}
