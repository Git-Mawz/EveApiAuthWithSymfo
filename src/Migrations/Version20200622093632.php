<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200622093632 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question ADD capsuler_id INT NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E866AC798 FOREIGN KEY (capsuler_id) REFERENCES capsuler (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E866AC798 ON question (capsuler_id)');
        $this->addSql('ALTER TABLE answer ADD capsuler_id INT NOT NULL');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25866AC798 FOREIGN KEY (capsuler_id) REFERENCES capsuler (id)');
        $this->addSql('CREATE INDEX IDX_DADD4A25866AC798 ON answer (capsuler_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25866AC798');
        $this->addSql('DROP INDEX IDX_DADD4A25866AC798 ON answer');
        $this->addSql('ALTER TABLE answer DROP capsuler_id');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E866AC798');
        $this->addSql('DROP INDEX IDX_B6F7494E866AC798 ON question');
        $this->addSql('ALTER TABLE question DROP capsuler_id');
    }
}
