<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322110719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE flyway_schema_history');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users (id SERIAL NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone_number VARCHAR(30) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(20) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\', updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\', active BOOLEAN DEFAULT false NOT NULL, deleted BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX users_email_key ON users (email)');
        $this->addSql('CREATE TABLE flyway_schema_history (installed_rank INT NOT NULL, version VARCHAR(50) DEFAULT NULL, description VARCHAR(200) NOT NULL, type VARCHAR(20) NOT NULL, script VARCHAR(1000) NOT NULL, checksum INT DEFAULT NULL, installed_by VARCHAR(100) NOT NULL, installed_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, execution_time INT NOT NULL, success BOOLEAN NOT NULL, PRIMARY KEY(installed_rank))');
        $this->addSql('CREATE INDEX flyway_schema_history_s_idx ON flyway_schema_history (success)');
    }
}
