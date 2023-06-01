<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601094038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shipping_details (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, building_number VARCHAR(255) NOT NULL, apartment VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, phone_nr VARCHAR(255) NOT NULL, shipping_type VARCHAR(255) NOT NULL, payment VARCHAR(255) NOT NULL, remarks VARCHAR(255) DEFAULT NULL, email VARCHAR(180) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD shipping_details_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993983E1577C FOREIGN KEY (shipping_details_id) REFERENCES shipping_details (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F52993983E1577C ON `order` (shipping_details_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993983E1577C');
        $this->addSql('DROP TABLE shipping_details');
        $this->addSql('DROP INDEX UNIQ_F52993983E1577C ON `order`');
        $this->addSql('ALTER TABLE `order` DROP shipping_details_id');
    }
}
