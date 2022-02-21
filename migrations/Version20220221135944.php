<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221135944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tools_animals_categories (tools_id INT NOT NULL, animals_categories_id INT NOT NULL, INDEX IDX_2F7C468E752C489C (tools_id), INDEX IDX_2F7C468E8B5CCA95 (animals_categories_id), PRIMARY KEY(tools_id, animals_categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tools_animals_categories ADD CONSTRAINT FK_2F7C468E752C489C FOREIGN KEY (tools_id) REFERENCES tools (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tools_animals_categories ADD CONSTRAINT FK_2F7C468E8B5CCA95 FOREIGN KEY (animals_categories_id) REFERENCES animals_categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animals ADD animal_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DDB5FC4E5B FOREIGN KEY (animal_category_id) REFERENCES animals_categories (id)');
        $this->addSql('CREATE INDEX IDX_966C69DDB5FC4E5B ON animals (animal_category_id)');
        $this->addSql('ALTER TABLE tools ADD user_id INT DEFAULT NULL, ADD category_tool_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tools ADD CONSTRAINT FK_EAFADE77A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tools ADD CONSTRAINT FK_EAFADE7748A362B2 FOREIGN KEY (category_tool_id) REFERENCES tool_categories (id)');
        $this->addSql('CREATE INDEX IDX_EAFADE77A76ED395 ON tools (user_id)');
        $this->addSql('CREATE INDEX IDX_EAFADE7748A362B2 ON tools (category_tool_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tools_animals_categories');
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DDB5FC4E5B');
        $this->addSql('DROP INDEX IDX_966C69DDB5FC4E5B ON animals');
        $this->addSql('ALTER TABLE animals DROP animal_category_id');
        $this->addSql('ALTER TABLE tools DROP FOREIGN KEY FK_EAFADE77A76ED395');
        $this->addSql('ALTER TABLE tools DROP FOREIGN KEY FK_EAFADE7748A362B2');
        $this->addSql('DROP INDEX IDX_EAFADE77A76ED395 ON tools');
        $this->addSql('DROP INDEX IDX_EAFADE7748A362B2 ON tools');
        $this->addSql('ALTER TABLE tools DROP user_id, DROP category_tool_id');
    }
}
