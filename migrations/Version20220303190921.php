<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220303190921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pictures_tools (id INT AUTO_INCREMENT NOT NULL, tool_id INT DEFAULT NULL, picture_tool_name VARCHAR(255) NOT NULL, INDEX IDX_F93BD7138F7B22CC (tool_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE populations_type (id INT AUTO_INCREMENT NOT NULL, population_type_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tools_populations_type (tools_id INT NOT NULL, populations_type_id INT NOT NULL, INDEX IDX_381EAB85752C489C (tools_id), INDEX IDX_381EAB85BA5C7D64 (populations_type_id), PRIMARY KEY(tools_id, populations_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pictures_tools ADD CONSTRAINT FK_F93BD7138F7B22CC FOREIGN KEY (tool_id) REFERENCES tools (id)');
        $this->addSql('ALTER TABLE tools_populations_type ADD CONSTRAINT FK_381EAB85752C489C FOREIGN KEY (tools_id) REFERENCES tools (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tools_populations_type ADD CONSTRAINT FK_381EAB85BA5C7D64 FOREIGN KEY (populations_type_id) REFERENCES populations_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE associations ADD association_logo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tools CHANGE tool_picture size_group VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tools_populations_type DROP FOREIGN KEY FK_381EAB85BA5C7D64');
        $this->addSql('DROP TABLE pictures_tools');
        $this->addSql('DROP TABLE populations_type');
        $this->addSql('DROP TABLE tools_populations_type');
        $this->addSql('ALTER TABLE animals CHANGE animal_name animal_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE animal_picture animal_picture VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE animal_content animal_content LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE animals_categories CHANGE animal_category_name animal_category_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE associations DROP association_logo, CHANGE association_name association_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE association_address association_address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE association_city association_city VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE association_mail association_mail VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE association_phone association_phone VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE association_content association_content LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE blog_categories CHANGE blog_category_name blog_category_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE blogs CHANGE blog_title blog_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE blog_subtitle blog_subtitle VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE blog_content blog_content LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE blog_author blog_author VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE contacts CHANGE contact_content contact_content LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contact_subject contact_subject VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contact_email contact_email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contact_fullname contact_fullname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contact_firstname contact_firstname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE partners CHANGE partner_name partner_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_address partner_address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_city partner_city VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_mail partner_mail VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_phone partner_phone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_content partner_content LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_picture partner_picture VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_web_link partner_web_link VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_referent partner_referent VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE pictures_association CHANGE picture_association_name picture_association_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE pictures_blog CHANGE picture_blog_name picture_blog_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE populations CHANGE population_name population_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tool_categories CHANGE tool_category_name tool_category_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tools ADD tool_picture VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP size_group, CHANGE tool_title tool_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tool_content tool_content LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tool_author tool_author VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname lastname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE firstname firstname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE picture picture VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE presentation presentation LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
