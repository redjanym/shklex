<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191017191911 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE field_transaction (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE field_value DROP created_at, CHANGE transaction_id transaction_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE field_value ADD CONSTRAINT FK_36D0CECF2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES field_transaction (id)');
        $this->addSql('CREATE INDEX IDX_36D0CECF2FC0CB0F ON field_value (transaction_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE field_value DROP FOREIGN KEY FK_36D0CECF2FC0CB0F');
        $this->addSql('DROP TABLE field_transaction');
        $this->addSql('DROP INDEX IDX_36D0CECF2FC0CB0F ON field_value');
        $this->addSql('ALTER TABLE field_value ADD created_at DATETIME NOT NULL, CHANGE transaction_id transaction_id INT NOT NULL');
    }
}
