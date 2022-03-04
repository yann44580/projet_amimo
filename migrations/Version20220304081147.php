<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220304081147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partners CHANGE partner_mail partner_mail VARCHAR(255) DEFAULT NULL, CHANGE partner_phone partner_phone VARCHAR(255) DEFAULT NULL, CHANGE partner_content partner_content LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partners CHANGE partner_mail partner_mail VARCHAR(255) NOT NULL, CHANGE partner_phone partner_phone VARCHAR(255) NOT NULL, CHANGE partner_content partner_content LONGTEXT NOT NULL');
    }
}
