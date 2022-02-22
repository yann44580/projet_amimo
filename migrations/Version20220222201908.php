<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222201908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animals (id INT AUTO_INCREMENT NOT NULL, animal_category_id INT DEFAULT NULL, animal_name VARCHAR(255) NOT NULL, animal_picture VARCHAR(255) NOT NULL, animal_content LONGTEXT NOT NULL, INDEX IDX_966C69DDB5FC4E5B (animal_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animals_categories (id INT AUTO_INCREMENT NOT NULL, animal_category_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE associations (id INT AUTO_INCREMENT NOT NULL, association_name VARCHAR(255) NOT NULL, association_address VARCHAR(255) NOT NULL, association_city VARCHAR(255) NOT NULL, association_mail VARCHAR(255) NOT NULL, association_phone VARCHAR(100) NOT NULL, association_content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_categories (id INT AUTO_INCREMENT NOT NULL, blog_category_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blogs (id INT AUTO_INCREMENT NOT NULL, blog_category_id INT DEFAULT NULL, blog_title VARCHAR(255) NOT NULL, blog_subtitle VARCHAR(255) DEFAULT NULL, blog_content LONGTEXT NOT NULL, blog_author VARCHAR(255) NOT NULL, blog_publication_date DATE NOT NULL, INDEX IDX_F41BCA70CB76011C (blog_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contacts (id INT AUTO_INCREMENT NOT NULL, contact_content LONGTEXT NOT NULL, contact_subject VARCHAR(255) NOT NULL, contact_date DATETIME NOT NULL, contact_email VARCHAR(255) NOT NULL, contact_fullname VARCHAR(255) NOT NULL, contact_firstname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partners (id INT AUTO_INCREMENT NOT NULL, partner_name VARCHAR(255) NOT NULL, partner_address VARCHAR(255) NOT NULL, partner_city VARCHAR(255) NOT NULL, partner_mail VARCHAR(255) NOT NULL, partner_phone VARCHAR(255) NOT NULL, partner_content LONGTEXT NOT NULL, partner_picture VARCHAR(255) NOT NULL, partner_web_link VARCHAR(255) DEFAULT NULL, partner_referent VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictures_association (id INT AUTO_INCREMENT NOT NULL, association_id INT DEFAULT NULL, picture_association_name VARCHAR(255) NOT NULL, INDEX IDX_B3619ABBEFB9C8A5 (association_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictures_blog (id INT AUTO_INCREMENT NOT NULL, blog_id INT DEFAULT NULL, picture_blog_name VARCHAR(255) NOT NULL, INDEX IDX_6D84635BDAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE populations (id INT AUTO_INCREMENT NOT NULL, population_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE populations_tools (populations_id INT NOT NULL, tools_id INT NOT NULL, INDEX IDX_7CEC3AFC30B53A1A (populations_id), INDEX IDX_7CEC3AFC752C489C (tools_id), PRIMARY KEY(populations_id, tools_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tool_categories (id INT AUTO_INCREMENT NOT NULL, tool_category_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tools (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, category_tool_id INT DEFAULT NULL, tool_title VARCHAR(255) NOT NULL, tool_content LONGTEXT NOT NULL, tool_picture VARCHAR(255) NOT NULL, tool_publication_date DATE NOT NULL, tool_author VARCHAR(255) NOT NULL, INDEX IDX_EAFADE77A76ED395 (user_id), INDEX IDX_EAFADE7748A362B2 (category_tool_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tools_animals_categories (tools_id INT NOT NULL, animals_categories_id INT NOT NULL, INDEX IDX_2F7C468E752C489C (tools_id), INDEX IDX_2F7C468E8B5CCA95 (animals_categories_id), PRIMARY KEY(tools_id, animals_categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, birthday_date DATE DEFAULT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, presentation LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DDB5FC4E5B FOREIGN KEY (animal_category_id) REFERENCES animals_categories (id)');
        $this->addSql('ALTER TABLE blogs ADD CONSTRAINT FK_F41BCA70CB76011C FOREIGN KEY (blog_category_id) REFERENCES blog_categories (id)');
        $this->addSql('ALTER TABLE pictures_association ADD CONSTRAINT FK_B3619ABBEFB9C8A5 FOREIGN KEY (association_id) REFERENCES associations (id)');
        $this->addSql('ALTER TABLE pictures_blog ADD CONSTRAINT FK_6D84635BDAE07E97 FOREIGN KEY (blog_id) REFERENCES blogs (id)');
        $this->addSql('ALTER TABLE populations_tools ADD CONSTRAINT FK_7CEC3AFC30B53A1A FOREIGN KEY (populations_id) REFERENCES populations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE populations_tools ADD CONSTRAINT FK_7CEC3AFC752C489C FOREIGN KEY (tools_id) REFERENCES tools (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tools ADD CONSTRAINT FK_EAFADE77A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tools ADD CONSTRAINT FK_EAFADE7748A362B2 FOREIGN KEY (category_tool_id) REFERENCES tool_categories (id)');
        $this->addSql('ALTER TABLE tools_animals_categories ADD CONSTRAINT FK_2F7C468E752C489C FOREIGN KEY (tools_id) REFERENCES tools (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tools_animals_categories ADD CONSTRAINT FK_2F7C468E8B5CCA95 FOREIGN KEY (animals_categories_id) REFERENCES animals_categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DDB5FC4E5B');
        $this->addSql('ALTER TABLE tools_animals_categories DROP FOREIGN KEY FK_2F7C468E8B5CCA95');
        $this->addSql('ALTER TABLE pictures_association DROP FOREIGN KEY FK_B3619ABBEFB9C8A5');
        $this->addSql('ALTER TABLE blogs DROP FOREIGN KEY FK_F41BCA70CB76011C');
        $this->addSql('ALTER TABLE pictures_blog DROP FOREIGN KEY FK_6D84635BDAE07E97');
        $this->addSql('ALTER TABLE populations_tools DROP FOREIGN KEY FK_7CEC3AFC30B53A1A');
        $this->addSql('ALTER TABLE tools DROP FOREIGN KEY FK_EAFADE7748A362B2');
        $this->addSql('ALTER TABLE populations_tools DROP FOREIGN KEY FK_7CEC3AFC752C489C');
        $this->addSql('ALTER TABLE tools_animals_categories DROP FOREIGN KEY FK_2F7C468E752C489C');
        $this->addSql('ALTER TABLE tools DROP FOREIGN KEY FK_EAFADE77A76ED395');
        $this->addSql('DROP TABLE animals');
        $this->addSql('DROP TABLE animals_categories');
        $this->addSql('DROP TABLE associations');
        $this->addSql('DROP TABLE blog_categories');
        $this->addSql('DROP TABLE blogs');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE partners');
        $this->addSql('DROP TABLE pictures_association');
        $this->addSql('DROP TABLE pictures_blog');
        $this->addSql('DROP TABLE populations');
        $this->addSql('DROP TABLE populations_tools');
        $this->addSql('DROP TABLE tool_categories');
        $this->addSql('DROP TABLE tools');
        $this->addSql('DROP TABLE tools_animals_categories');
        $this->addSql('DROP TABLE users');
    }
}
