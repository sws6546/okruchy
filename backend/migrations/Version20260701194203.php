<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260701194203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__logins AS SELECT id, ip, created_date, writer_id FROM logins');
        $this->addSql('DROP TABLE logins');
        $this->addSql('CREATE TABLE logins (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ip CLOB NOT NULL, created_date DATETIME NOT NULL, writer_id INTEGER NOT NULL, CONSTRAINT FK_613D7A41BC7E6B6 FOREIGN KEY (writer_id) REFERENCES writer (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO logins (id, ip, created_date, writer_id) SELECT id, ip, created_date, writer_id FROM __temp__logins');
        $this->addSql('DROP TABLE __temp__logins');
        $this->addSql('CREATE INDEX IDX_613D7A41BC7E6B6 ON logins (writer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__logins AS SELECT id, ip, created_date, writer_id FROM logins');
        $this->addSql('DROP TABLE logins');
        $this->addSql('CREATE TABLE logins (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ip CLOB NOT NULL, created_date DATETIME NOT NULL, writer_id INTEGER NOT NULL, CONSTRAINT FK_613D7A41BC7E6B6 FOREIGN KEY (writer_id) REFERENCES writer (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO logins (id, ip, created_date, writer_id) SELECT id, ip, created_date, writer_id FROM __temp__logins');
        $this->addSql('DROP TABLE __temp__logins');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_613D7A41BC7E6B6 ON logins (writer_id)');
    }
}
