<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222141104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE populations_tools (populations_id INT NOT NULL, tools_id INT NOT NULL, INDEX IDX_7CEC3AFC30B53A1A (populations_id), INDEX IDX_7CEC3AFC752C489C (tools_id), PRIMARY KEY(populations_id, tools_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE populations_tools ADD CONSTRAINT FK_7CEC3AFC30B53A1A FOREIGN KEY (populations_id) REFERENCES populations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE populations_tools ADD CONSTRAINT FK_7CEC3AFC752C489C FOREIGN KEY (tools_id) REFERENCES tools (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE populations_tools');
    }
}
