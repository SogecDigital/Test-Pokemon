<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604115341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pokemon DROP CONSTRAINT fk_62dc90f3bfafa3e1');
        $this->addSql('ALTER TABLE pokemon DROP CONSTRAINT fk_62dc90f3ad1a0c0f');
        $this->addSql('DROP INDEX idx_62dc90f3ad1a0c0f');
        $this->addSql('DROP INDEX idx_62dc90f3bfafa3e1');
        $this->addSql('ALTER TABLE pokemon DROP type1_id');
        $this->addSql('ALTER TABLE pokemon DROP type2_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pokemon ADD type1_id INT NOT NULL');
        $this->addSql('ALTER TABLE pokemon ADD type2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT fk_62dc90f3bfafa3e1 FOREIGN KEY (type1_id) REFERENCES pokemon_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT fk_62dc90f3ad1a0c0f FOREIGN KEY (type2_id) REFERENCES pokemon_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_62dc90f3ad1a0c0f ON pokemon (type2_id)');
        $this->addSql('CREATE INDEX idx_62dc90f3bfafa3e1 ON pokemon (type1_id)');
    }
}
