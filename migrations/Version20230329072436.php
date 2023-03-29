<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329072436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, address LONGTEXT NOT NULL, city VARCHAR(150) NOT NULL, country VARCHAR(150) NOT NULL, postal_code INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE archive_cart (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, billing_address_id INT NOT NULL, delivery_address_id INT NOT NULL, discount_percentage INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3B865E2CA76ED395 (user_id), INDEX IDX_3B865E2C79D0C0E4 (billing_address_id), INDEX IDX_3B865E2CEBF23851 (delivery_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE archive_cart_product (id INT AUTO_INCREMENT NOT NULL, archive_cart_id INT NOT NULL, name VARCHAR(150) NOT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, brand_name VARCHAR(150) NOT NULL, collection_name VARCHAR(150) DEFAULT NULL, category_name VARCHAR(150) NOT NULL, weight DOUBLE PRECISION NOT NULL, stringify_product_attributs LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_64297E7177F52C40 (archive_cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, billing_address_id INT DEFAULT NULL, delivery_address_id INT DEFAULT NULL, discount_percentage INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_BA388B7A76ED395 (user_id), INDEX IDX_BA388B779D0C0E4 (billing_address_id), INDEX IDX_BA388B7EBF23851 (delivery_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_product (id INT AUTO_INCREMENT NOT NULL, cart_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2890CCAA1AD5CDBF (cart_id), INDEX IDX_2890CCAA4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, archive_cart_id INT NOT NULL, order_status_id INT NOT NULL, total DOUBLE PRECISION NOT NULL, reference VARCHAR(200) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_F529939877F52C40 (archive_cart_id), INDEX IDX_F5299398D7707B45 (order_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(150) NOT NULL, color VARCHAR(70) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, collection_id INT DEFAULT NULL, category_id INT NOT NULL, name VARCHAR(150) NOT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, weight DOUBLE PRECISION NOT NULL, image_url LONGTEXT DEFAULT NULL, is_available TINYINT(1) NOT NULL, is_new TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D34A04AD44F5D008 (brand_id), INDEX IDX_D34A04AD514956FD (collection_id), INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_product_attribut (product_id INT NOT NULL, product_attribut_id INT NOT NULL, INDEX IDX_3F84E6364584665A (product_id), INDEX IDX_3F84E636FD17A4EC (product_attribut_id), PRIMARY KEY(product_id, product_attribut_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_attribut (id INT AUTO_INCREMENT NOT NULL, product_attribut_category_id INT NOT NULL, name VARCHAR(100) NOT NULL, value VARCHAR(150) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B10882CA952D0719 (product_attribut_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_attribut_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_collection (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_rating (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, comment LONGTEXT NOT NULL, rating DOUBLE PRECISION NOT NULL, INDEX IDX_BAF567864584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, billing_address_id INT DEFAULT NULL, delivery_address_id INT DEFAULT NULL, username VARCHAR(100) NOT NULL, firstname VARCHAR(100) DEFAULT NULL, lastname VARCHAR(100) DEFAULT NULL, email VARCHAR(255) NOT NULL, password LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D64979D0C0E4 (billing_address_id), UNIQUE INDEX UNIQ_8D93D649EBF23851 (delivery_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE archive_cart ADD CONSTRAINT FK_3B865E2CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE archive_cart ADD CONSTRAINT FK_3B865E2C79D0C0E4 FOREIGN KEY (billing_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE archive_cart ADD CONSTRAINT FK_3B865E2CEBF23851 FOREIGN KEY (delivery_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE archive_cart_product ADD CONSTRAINT FK_64297E7177F52C40 FOREIGN KEY (archive_cart_id) REFERENCES archive_cart (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B779D0C0E4 FOREIGN KEY (billing_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAA1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAA4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939877F52C40 FOREIGN KEY (archive_cart_id) REFERENCES archive_cart (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398D7707B45 FOREIGN KEY (order_status_id) REFERENCES order_status (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD44F5D008 FOREIGN KEY (brand_id) REFERENCES product_brand (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD514956FD FOREIGN KEY (collection_id) REFERENCES product_collection (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES product_category (id)');
        $this->addSql('ALTER TABLE product_product_attribut ADD CONSTRAINT FK_3F84E6364584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product_attribut ADD CONSTRAINT FK_3F84E636FD17A4EC FOREIGN KEY (product_attribut_id) REFERENCES product_attribut (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_attribut ADD CONSTRAINT FK_B10882CA952D0719 FOREIGN KEY (product_attribut_category_id) REFERENCES product_attribut_category (id)');
        $this->addSql('ALTER TABLE product_rating ADD CONSTRAINT FK_BAF567864584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64979D0C0E4 FOREIGN KEY (billing_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archive_cart DROP FOREIGN KEY FK_3B865E2CA76ED395');
        $this->addSql('ALTER TABLE archive_cart DROP FOREIGN KEY FK_3B865E2C79D0C0E4');
        $this->addSql('ALTER TABLE archive_cart DROP FOREIGN KEY FK_3B865E2CEBF23851');
        $this->addSql('ALTER TABLE archive_cart_product DROP FOREIGN KEY FK_64297E7177F52C40');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B779D0C0E4');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7EBF23851');
        $this->addSql('ALTER TABLE cart_product DROP FOREIGN KEY FK_2890CCAA1AD5CDBF');
        $this->addSql('ALTER TABLE cart_product DROP FOREIGN KEY FK_2890CCAA4584665A');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939877F52C40');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398D7707B45');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD44F5D008');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD514956FD');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product_product_attribut DROP FOREIGN KEY FK_3F84E6364584665A');
        $this->addSql('ALTER TABLE product_product_attribut DROP FOREIGN KEY FK_3F84E636FD17A4EC');
        $this->addSql('ALTER TABLE product_attribut DROP FOREIGN KEY FK_B10882CA952D0719');
        $this->addSql('ALTER TABLE product_rating DROP FOREIGN KEY FK_BAF567864584665A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64979D0C0E4');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EBF23851');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE archive_cart');
        $this->addSql('DROP TABLE archive_cart_product');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_product');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_product_attribut');
        $this->addSql('DROP TABLE product_attribut');
        $this->addSql('DROP TABLE product_attribut_category');
        $this->addSql('DROP TABLE product_brand');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE product_collection');
        $this->addSql('DROP TABLE product_rating');
        $this->addSql('DROP TABLE user');
    }
}
