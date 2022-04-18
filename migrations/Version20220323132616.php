<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220323132616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animals CHANGE animal_name animal_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE animal_picture animal_picture VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE animal_content animal_content LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE animals_categories CHANGE animal_category_name animal_category_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE associations CHANGE association_name association_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE association_address association_address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE association_city association_city VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE association_mail association_mail VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE association_phone association_phone VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE association_content association_content LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE association_logo association_logo VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE association_statut association_statut LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE associations_rgpd associations_rgpd LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE association_mentions_legales association_mentions_legales LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE blog_categories CHANGE blog_category_name blog_category_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE blogs CHANGE blog_title blog_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE blog_subtitle blog_subtitle VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE blog_content blog_content LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE blog_author blog_author VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE contacts CHANGE contact_content contact_content LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contact_subject contact_subject VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contact_email contact_email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contact_fullname contact_fullname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contact_firstname contact_firstname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE mediations CHANGE mediation_history mediation_history LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mediation_pedagogy mediation_pedagogy LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mediation_definition mediation_definition LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mediation_biography mediation_biography LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mediation_objectif mediation_objectif LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mediation_methods mediation_methods LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE partners CHANGE partner_name partner_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_address partner_address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_city partner_city VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_mail partner_mail VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_phone partner_phone VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_content partner_content LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_picture partner_picture VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_web_link partner_web_link VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE partner_referent partner_referent VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE pictures_association CHANGE picture_association_name picture_association_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE pictures_blog CHANGE picture_blog_name picture_blog_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE pictures_tools CHANGE picture_tool_name picture_tool_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE populations CHANGE population_name population_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE populations_type CHANGE population_type_name population_type_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reset_password_request CHANGE selector selector VARCHAR(20) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE hashed_token hashed_token VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tool_categories CHANGE tool_category_name tool_category_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tools CHANGE tool_title tool_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tool_content tool_content LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tool_author tool_author VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE size_group size_group VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tool_content2 tool_content2 LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tool_content3 tool_content3 LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tool_item tool_item VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE document_tool document_tool VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tool_content4 tool_content4 LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tool_content5 tool_content5 LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname lastname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE firstname firstname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE picture picture VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE presentation presentation LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE reset_token reset_token VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
