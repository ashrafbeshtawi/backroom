<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230802090907 extends AbstractMigration
{
    public function getDescription(): string {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE flyway_schema_history');
        $this->addSql('ALTER TABLE profile ADD first_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE profile ADD last_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE profile DROP greeting');
        $this->addSql('ALTER TABLE profile DROP name');
        $this->addSql('ALTER TABLE profile DROP created_at');
        $this->addSql('ALTER TABLE profile DROP updated_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE flyway_schema_history (installed_rank INT NOT NULL, version VARCHAR(50) DEFAULT NULL, description VARCHAR(200) NOT NULL, type VARCHAR(20) NOT NULL, script VARCHAR(1000) NOT NULL, checksum INT DEFAULT NULL, installed_by VARCHAR(100) NOT NULL, installed_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, execution_time INT NOT NULL, success BOOLEAN NOT NULL, PRIMARY KEY(installed_rank))');
        $this->addSql('CREATE INDEX flyway_schema_history_s_idx ON flyway_schema_history (success)');
        $this->addSql('ALTER TABLE profile ADD greeting VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE profile ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE profile ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE profile ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE profile DROP first_name');
        $this->addSql('ALTER TABLE profile DROP last_name');
        $this->addSql('COMMENT ON COLUMN profile.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN profile.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }
}
