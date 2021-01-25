<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200919050437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wallets (id INT AUTO_INCREMENT NOT NULL, account_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, currency VARCHAR(255) DEFAULT NULL, balance INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_967AAA6C9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6C9B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accounts ADD active_wallet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE accounts ADD CONSTRAINT FK_CAC89EAC67B363C7 FOREIGN KEY (active_wallet_id) REFERENCES wallets (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_CAC89EAC67B363C7 ON accounts (active_wallet_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounts DROP FOREIGN KEY FK_CAC89EAC67B363C7');
        $this->addSql('DROP TABLE wallets');
        $this->addSql('DROP INDEX IDX_CAC89EAC67B363C7 ON accounts');
        $this->addSql('ALTER TABLE accounts DROP active_wallet_id');
    }
}
