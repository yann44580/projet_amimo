<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220302130856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tools_populations_type (tools_id INT NOT NULL, populations_type_id INT NOT NULL, INDEX IDX_381EAB85752C489C (tools_id), INDEX IDX_381EAB85BA5C7D64 (populations_type_id), PRIMARY KEY(tools_id, populations_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tools_populations_type ADD CONSTRAINT FK_381EAB85752C489C FOREIGN KEY (tools_id) REFERENCES tools (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tools_populations_type ADD CONSTRAINT FK_381EAB85BA5C7D64 FOREIGN KEY (populations_type_id) REFERENCES populations_type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tools_populations_type');
    }
}
