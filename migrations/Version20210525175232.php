<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210525175232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT NOT NULL, learner_id INT NOT NULL, lesson_id INT NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E00CEDDE6209CB66 ON booking (learner_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDECDF80196 ON booking (lesson_id)');
        $this->addSql('CREATE TABLE learner (id INT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE lesson (id INT NOT NULL, starts_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ends_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE6209CB66 FOREIGN KEY (learner_id) REFERENCES learner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDECDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE6209CB66');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDECDF80196');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE learner');
        $this->addSql('DROP TABLE lesson');
    }
}
