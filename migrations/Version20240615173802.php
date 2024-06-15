<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240615173802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE product_attribute_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE product_attribute (id INT NOT NULL, product_id INT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_94DA59764584665A ON product_attribute (product_id)');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA59764584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product DROP flavor');
        $this->addSql('ALTER TABLE product DROP color');
        $this->addSql('ALTER TABLE product DROP is_vegan');
        $this->addSql('ALTER TABLE product DROP difficulty');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE product_attribute_id_seq CASCADE');
        $this->addSql('ALTER TABLE product_attribute DROP CONSTRAINT FK_94DA59764584665A');
        $this->addSql('DROP TABLE product_attribute');
        $this->addSql('ALTER TABLE product ADD flavor VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product ADD color VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product ADD is_vegan BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE product ADD difficulty VARCHAR(255) DEFAULT NULL');
    }
}
