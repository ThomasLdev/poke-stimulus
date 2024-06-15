<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240611201810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD flavor VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product ADD color VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product ADD is_vegan BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE product ADD difficulty VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product DROP flavor');
        $this->addSql('ALTER TABLE product DROP color');
        $this->addSql('ALTER TABLE product DROP is_vegan');
        $this->addSql('ALTER TABLE product DROP difficulty');
    }
}
