<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260701202323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create image_component table with disk name, author and author ip';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE image_component (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, original_name CLOB NOT NULL, name CLOB DEFAULT NULL, author_id INTEGER NOT NULL, author_ip CLOB NOT NULL, CONSTRAINT FK_2C15FBB4F675F09E FOREIGN KEY (author_id) REFERENCES writer (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_2C15FBB4F675F09E ON image_component (author_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE image_component');
    }
}
