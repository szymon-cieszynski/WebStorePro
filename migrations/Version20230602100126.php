<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230602100126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shipping_details DROP INDEX UNIQ_946E0D4E5AA1164F, ADD INDEX IDX_946E0D4E5AA1164F (payment_method_id)');
        $this->addSql('ALTER TABLE shipping_details DROP INDEX UNIQ_946E0D4E23048A57, ADD INDEX IDX_946E0D4E23048A57 (shipping_type_id)');
        $this->addSql('ALTER TABLE shipping_details DROP payment');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shipping_details DROP INDEX IDX_946E0D4E5AA1164F, ADD UNIQUE INDEX UNIQ_946E0D4E5AA1164F (payment_method_id)');
        $this->addSql('ALTER TABLE shipping_details DROP INDEX IDX_946E0D4E23048A57, ADD UNIQUE INDEX UNIQ_946E0D4E23048A57 (shipping_type_id)');
        $this->addSql('ALTER TABLE shipping_details ADD payment VARCHAR(255) NOT NULL');
    }
}
