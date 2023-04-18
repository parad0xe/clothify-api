<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230405090907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_item (id INT AUTO_INCREMENT NOT NULL, cart_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F0FE25271AD5CDBF (cart_id), INDEX IDX_F0FE25274584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_item_product_attribut (cart_item_id INT NOT NULL, product_attribut_id INT NOT NULL, INDEX IDX_B72A7161E9B59A59 (cart_item_id), INDEX IDX_B72A7161FD17A4EC (product_attribut_id), PRIMARY KEY(cart_item_id, product_attribut_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25271AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25274584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE cart_item_product_attribut ADD CONSTRAINT FK_B72A7161E9B59A59 FOREIGN KEY (cart_item_id) REFERENCES cart_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_item_product_attribut ADD CONSTRAINT FK_B72A7161FD17A4EC FOREIGN KEY (product_attribut_id) REFERENCES product_attribut (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_product DROP FOREIGN KEY FK_2890CCAA1AD5CDBF');
        $this->addSql('ALTER TABLE cart_product DROP FOREIGN KEY FK_2890CCAA4584665A');
        $this->addSql('ALTER TABLE cart_product_product_attribut DROP FOREIGN KEY FK_9FB310E925EE16A8');
        $this->addSql('ALTER TABLE cart_product_product_attribut DROP FOREIGN KEY FK_9FB310E9FD17A4EC');
        $this->addSql('DROP TABLE cart_product');
        $this->addSql('DROP TABLE cart_product_product_attribut');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_product (id INT AUTO_INCREMENT NOT NULL, cart_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2890CCAA1AD5CDBF (cart_id), INDEX IDX_2890CCAA4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE cart_product_product_attribut (cart_product_id INT NOT NULL, product_attribut_id INT NOT NULL, INDEX IDX_9FB310E9FD17A4EC (product_attribut_id), INDEX IDX_9FB310E925EE16A8 (cart_product_id), PRIMARY KEY(cart_product_id, product_attribut_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAA1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAA4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE cart_product_product_attribut ADD CONSTRAINT FK_9FB310E925EE16A8 FOREIGN KEY (cart_product_id) REFERENCES cart_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_product_product_attribut ADD CONSTRAINT FK_9FB310E9FD17A4EC FOREIGN KEY (product_attribut_id) REFERENCES product_attribut (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25271AD5CDBF');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25274584665A');
        $this->addSql('ALTER TABLE cart_item_product_attribut DROP FOREIGN KEY FK_B72A7161E9B59A59');
        $this->addSql('ALTER TABLE cart_item_product_attribut DROP FOREIGN KEY FK_B72A7161FD17A4EC');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('DROP TABLE cart_item_product_attribut');
    }
}
