<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200920000031 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_preferences (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, active_wallet_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1E849A07A76ED395 (user_id), INDEX IDX_1E849A0767B363C7 (active_wallet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_preferences ADD CONSTRAINT FK_1E849A07A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_preferences ADD CONSTRAINT FK_1E849A0767B363C7 FOREIGN KEY (active_wallet_id) REFERENCES wallets (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE accounts DROP FOREIGN KEY FK_CAC89EAC67B363C7');
        $this->addSql('DROP INDEX IDX_CAC89EAC67B363C7 ON accounts');
        $this->addSql('ALTER TABLE accounts DROP active_wallet_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users_preferences');
        $this->addSql('ALTER TABLE accounts ADD active_wallet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE accounts ADD CONSTRAINT FK_CAC89EAC67B363C7 FOREIGN KEY (active_wallet_id) REFERENCES wallets (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_CAC89EAC67B363C7 ON accounts (active_wallet_id)');
    }
}
