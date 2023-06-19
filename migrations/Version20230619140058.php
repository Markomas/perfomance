<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230619140058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE run (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, project_id INTEGER DEFAULT NULL, datetime DATETIME NOT NULL, CONSTRAINT FK_5076A4C0166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5076A4C0166D1F9C ON run (project_id)');
        $this->addSql('CREATE TABLE test_case (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, test_suite_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, time INTEGER NOT NULL, CONSTRAINT FK_7D71B3CBDA9FBE4E FOREIGN KEY (test_suite_id) REFERENCES test_suite (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_7D71B3CBDA9FBE4E ON test_case (test_suite_id)');
        $this->addSql('CREATE TABLE test_suite (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, run_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, time INTEGER NOT NULL, failed BOOLEAN NOT NULL, CONSTRAINT FK_1EE2422D84E3FEC4 FOREIGN KEY (run_id) REFERENCES run (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_1EE2422D84E3FEC4 ON test_suite (run_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE run');
        $this->addSql('DROP TABLE test_case');
        $this->addSql('DROP TABLE test_suite');
    }
}
