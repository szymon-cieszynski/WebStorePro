<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601101552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment_methods (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shipping_details ADD payment_method_id INT NOT NULL, ADD shipping_type_id INT NOT NULL, DROP shipping_type');
        $this->addSql('ALTER TABLE shipping_details ADD CONSTRAINT FK_946E0D4E5AA1164F FOREIGN KEY (payment_method_id) REFERENCES payment_methods (id)');
        $this->addSql('ALTER TABLE shipping_details ADD CONSTRAINT FK_946E0D4E23048A57 FOREIGN KEY (shipping_type_id) REFERENCES shipping_type (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_946E0D4E5AA1164F ON shipping_details (payment_method_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_946E0D4E23048A57 ON shipping_details (shipping_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shipping_details DROP FOREIGN KEY FK_946E0D4E5AA1164F');
        $this->addSql('DROP TABLE payment_methods');
        $this->addSql('ALTER TABLE shipping_details DROP FOREIGN KEY FK_946E0D4E23048A57');
        $this->addSql('DROP INDEX UNIQ_946E0D4E5AA1164F ON shipping_details');
        $this->addSql('DROP INDEX UNIQ_946E0D4E23048A57 ON shipping_details');
        $this->addSql('ALTER TABLE shipping_details ADD shipping_type VARCHAR(255) NOT NULL, DROP payment_method_id, DROP shipping_type_id');
    }
}
