<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122231652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stats DROP CONSTRAINT fk_574767aa8f3ec46');
        $this->addSql('DROP INDEX uniq_574767aa8f3ec46');
        $this->addSql('ALTER TABLE stats RENAME COLUMN article_id_id TO article_id');
        $this->addSql('ALTER TABLE stats ADD CONSTRAINT FK_574767AA7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_574767AA7294869C ON stats (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE stats DROP CONSTRAINT FK_574767AA7294869C');
        $this->addSql('DROP INDEX IDX_574767AA7294869C');
        $this->addSql('ALTER TABLE stats RENAME COLUMN article_id TO article_id_id');
        $this->addSql('ALTER TABLE stats ADD CONSTRAINT fk_574767aa8f3ec46 FOREIGN KEY (article_id_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_574767aa8f3ec46 ON stats (article_id_id)');
    }
}
