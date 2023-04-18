<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230402094110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_product_product_attribut (cart_product_id INT NOT NULL, product_attribut_id INT NOT NULL, INDEX IDX_9FB310E925EE16A8 (cart_product_id), INDEX IDX_9FB310E9FD17A4EC (product_attribut_id), PRIMARY KEY(cart_product_id, product_attribut_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart_product_product_attribut ADD CONSTRAINT FK_9FB310E925EE16A8 FOREIGN KEY (cart_product_id) REFERENCES cart_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_product_product_attribut ADD CONSTRAINT FK_9FB310E9FD17A4EC FOREIGN KEY (product_attribut_id) REFERENCES product_attribut (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_product_product_attribut DROP FOREIGN KEY FK_9FB310E925EE16A8');
        $this->addSql('ALTER TABLE cart_product_product_attribut DROP FOREIGN KEY FK_9FB310E9FD17A4EC');
        $this->addSql('DROP TABLE cart_product_product_attribut');
    }
}
