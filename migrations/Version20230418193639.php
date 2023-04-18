<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230418193639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_item_product_attribut (order_item_id INT NOT NULL, product_attribut_id INT NOT NULL, INDEX IDX_BC61ED79E415FB15 (order_item_id), INDEX IDX_BC61ED79FD17A4EC (product_attribut_id), PRIMARY KEY(order_item_id, product_attribut_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_item_product_attribut ADD CONSTRAINT FK_BC61ED79E415FB15 FOREIGN KEY (order_item_id) REFERENCES order_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_item_product_attribut ADD CONSTRAINT FK_BC61ED79FD17A4EC FOREIGN KEY (product_attribut_id) REFERENCES product_attribut (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_item_product_attribut DROP FOREIGN KEY FK_BC61ED79E415FB15');
        $this->addSql('ALTER TABLE order_item_product_attribut DROP FOREIGN KEY FK_BC61ED79FD17A4EC');
        $this->addSql('DROP TABLE order_item_product_attribut');
    }
}
