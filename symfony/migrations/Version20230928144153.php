<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230928144153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE profile_picture_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE picture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE picture (id INT NOT NULL, profile_id INT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_16DB4F89CCFA12B8 ON picture (profile_id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE profile_picture');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE picture_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE profile_picture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE profile_picture (id INT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE picture DROP CONSTRAINT FK_16DB4F89CCFA12B8');
        $this->addSql('DROP TABLE picture');
    }
}
