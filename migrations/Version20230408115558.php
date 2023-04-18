<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230408115558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939877F52C40');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398D7707B45');
        $this->addSql('ALTER TABLE archive_cart DROP FOREIGN KEY FK_3B865E2CA76ED395');
        $this->addSql('ALTER TABLE archive_cart DROP FOREIGN KEY FK_3B865E2CEBF23851');
        $this->addSql('ALTER TABLE archive_cart DROP FOREIGN KEY FK_3B865E2C79D0C0E4');
        $this->addSql('ALTER TABLE archive_cart_product DROP FOREIGN KEY FK_64297E7177F52C40');
        $this->addSql('DROP TABLE archive_cart');
        $this->addSql('DROP TABLE archive_cart_product');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP INDEX UNIQ_F529939877F52C40 ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398D7707B45 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP archive_cart_id, DROP order_status_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE archive_cart (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, billing_address_id INT NOT NULL, delivery_address_id INT NOT NULL, discount_percentage INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3B865E2C79D0C0E4 (billing_address_id), INDEX IDX_3B865E2CEBF23851 (delivery_address_id), INDEX IDX_3B865E2CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE archive_cart_product (id INT AUTO_INCREMENT NOT NULL, archive_cart_id INT NOT NULL, name VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, price DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, brand_name VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, collection_name VARCHAR(150) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, category_name VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, weight DOUBLE PRECISION NOT NULL, stringify_product_attributs LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_64297E7177F52C40 (archive_cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE order_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, value VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, color VARCHAR(70) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE archive_cart ADD CONSTRAINT FK_3B865E2CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE archive_cart ADD CONSTRAINT FK_3B865E2CEBF23851 FOREIGN KEY (delivery_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE archive_cart ADD CONSTRAINT FK_3B865E2C79D0C0E4 FOREIGN KEY (billing_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE archive_cart_product ADD CONSTRAINT FK_64297E7177F52C40 FOREIGN KEY (archive_cart_id) REFERENCES archive_cart (id)');
        $this->addSql('ALTER TABLE `order` ADD archive_cart_id INT NOT NULL, ADD order_status_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939877F52C40 FOREIGN KEY (archive_cart_id) REFERENCES archive_cart (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398D7707B45 FOREIGN KEY (order_status_id) REFERENCES order_status (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F529939877F52C40 ON `order` (archive_cart_id)');
        $this->addSql('CREATE INDEX IDX_F5299398D7707B45 ON `order` (order_status_id)');
    }
}
