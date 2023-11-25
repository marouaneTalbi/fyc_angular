<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122222123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE stats_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE stats (id INT NOT NULL, article_id_id INT NOT NULL, views VARCHAR(255) NOT NULL, likes VARCHAR(255) NOT NULL, shares VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_574767AA8F3EC46 ON stats (article_id_id)');
        $this->addSql('ALTER TABLE stats ADD CONSTRAINT FK_574767AA8F3EC46 FOREIGN KEY (article_id_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE stats_id_seq CASCADE');
        $this->addSql('ALTER TABLE stats DROP CONSTRAINT FK_574767AA8F3EC46');
        $this->addSql('DROP TABLE stats');
    }
}
