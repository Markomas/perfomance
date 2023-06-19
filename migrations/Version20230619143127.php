<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230619143127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__test_case AS SELECT id, test_suite_id, name, time FROM test_case');
        $this->addSql('DROP TABLE test_case');
        $this->addSql('CREATE TABLE test_case (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, test_suite_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, time DOUBLE PRECISION NOT NULL, CONSTRAINT FK_7D71B3CBDA9FBE4E FOREIGN KEY (test_suite_id) REFERENCES test_suite (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO test_case (id, test_suite_id, name, time) SELECT id, test_suite_id, name, time FROM __temp__test_case');
        $this->addSql('DROP TABLE __temp__test_case');
        $this->addSql('CREATE INDEX IDX_7D71B3CBDA9FBE4E ON test_case (test_suite_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__test_suite AS SELECT id, run_id, name, time, failed FROM test_suite');
        $this->addSql('DROP TABLE test_suite');
        $this->addSql('CREATE TABLE test_suite (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, run_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, time DOUBLE PRECISION NOT NULL, failed BOOLEAN NOT NULL, CONSTRAINT FK_1EE2422D84E3FEC4 FOREIGN KEY (run_id) REFERENCES run (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO test_suite (id, run_id, name, time, failed) SELECT id, run_id, name, time, failed FROM __temp__test_suite');
        $this->addSql('DROP TABLE __temp__test_suite');
        $this->addSql('CREATE INDEX IDX_1EE2422D84E3FEC4 ON test_suite (run_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__test_case AS SELECT id, test_suite_id, name, time FROM test_case');
        $this->addSql('DROP TABLE test_case');
        $this->addSql('CREATE TABLE test_case (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, test_suite_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, time INTEGER NOT NULL, CONSTRAINT FK_7D71B3CBDA9FBE4E FOREIGN KEY (test_suite_id) REFERENCES test_suite (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO test_case (id, test_suite_id, name, time) SELECT id, test_suite_id, name, time FROM __temp__test_case');
        $this->addSql('DROP TABLE __temp__test_case');
        $this->addSql('CREATE INDEX IDX_7D71B3CBDA9FBE4E ON test_case (test_suite_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__test_suite AS SELECT id, run_id, name, time, failed FROM test_suite');
        $this->addSql('DROP TABLE test_suite');
        $this->addSql('CREATE TABLE test_suite (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, run_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, time INTEGER NOT NULL, failed BOOLEAN NOT NULL, CONSTRAINT FK_1EE2422D84E3FEC4 FOREIGN KEY (run_id) REFERENCES run (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO test_suite (id, run_id, name, time, failed) SELECT id, run_id, name, time, failed FROM __temp__test_suite');
        $this->addSql('DROP TABLE __temp__test_suite');
        $this->addSql('CREATE INDEX IDX_1EE2422D84E3FEC4 ON test_suite (run_id)');
    }
}
