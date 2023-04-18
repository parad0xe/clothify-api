<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230418142041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address CHANGE postal_code postal_code VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7EBF23851');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B779D0C0E4');
        $this->addSql('DROP INDEX IDX_BA388B7EBF23851 ON cart');
        $this->addSql('DROP INDEX IDX_BA388B779D0C0E4 ON cart');
        $this->addSql('ALTER TABLE cart DROP billing_address_id, DROP delivery_address_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address CHANGE postal_code postal_code INT NOT NULL');
        $this->addSql('ALTER TABLE cart ADD billing_address_id INT DEFAULT NULL, ADD delivery_address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B779D0C0E4 FOREIGN KEY (billing_address_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_BA388B7EBF23851 ON cart (delivery_address_id)');
        $this->addSql('CREATE INDEX IDX_BA388B779D0C0E4 ON cart (billing_address_id)');
    }
}
