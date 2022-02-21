<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221133505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictures_association ADD association_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pictures_association ADD CONSTRAINT FK_B3619ABBEFB9C8A5 FOREIGN KEY (association_id) REFERENCES associations (id)');
        $this->addSql('CREATE INDEX IDX_B3619ABBEFB9C8A5 ON pictures_association (association_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictures_association DROP FOREIGN KEY FK_B3619ABBEFB9C8A5');
        $this->addSql('DROP INDEX IDX_B3619ABBEFB9C8A5 ON pictures_association');
        $this->addSql('ALTER TABLE pictures_association DROP association_id');
    }
}
