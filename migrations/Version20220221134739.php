<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221134739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blogs ADD blog_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blogs ADD CONSTRAINT FK_F41BCA70CB76011C FOREIGN KEY (blog_category_id) REFERENCES blog_categories (id)');
        $this->addSql('CREATE INDEX IDX_F41BCA70CB76011C ON blogs (blog_category_id)');
        $this->addSql('ALTER TABLE pictures_blog ADD blog_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pictures_blog ADD CONSTRAINT FK_6D84635BDAE07E97 FOREIGN KEY (blog_id) REFERENCES blogs (id)');
        $this->addSql('CREATE INDEX IDX_6D84635BDAE07E97 ON pictures_blog (blog_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blogs DROP FOREIGN KEY FK_F41BCA70CB76011C');
        $this->addSql('DROP INDEX IDX_F41BCA70CB76011C ON blogs');
        $this->addSql('ALTER TABLE blogs DROP blog_category_id');
        $this->addSql('ALTER TABLE pictures_blog DROP FOREIGN KEY FK_6D84635BDAE07E97');
        $this->addSql('DROP INDEX IDX_6D84635BDAE07E97 ON pictures_blog');
        $this->addSql('ALTER TABLE pictures_blog DROP blog_id');
    }
}
