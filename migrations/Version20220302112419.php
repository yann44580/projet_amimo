<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220302112419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE populations_type (id INT AUTO_INCREMENT NOT NULL, population_type_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE populations_type_populations (populations_type_id INT NOT NULL, populations_id INT NOT NULL, INDEX IDX_2844055BA5C7D64 (populations_type_id), INDEX IDX_284405530B53A1A (populations_id), PRIMARY KEY(populations_type_id, populations_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE populations_type_populations ADD CONSTRAINT FK_2844055BA5C7D64 FOREIGN KEY (populations_type_id) REFERENCES populations_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE populations_type_populations ADD CONSTRAINT FK_284405530B53A1A FOREIGN KEY (populations_id) REFERENCES populations (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE populations_type_populations DROP FOREIGN KEY FK_2844055BA5C7D64');
        $this->addSql('DROP TABLE populations_type');
        $this->addSql('DROP TABLE populations_type_populations');
    }
}
