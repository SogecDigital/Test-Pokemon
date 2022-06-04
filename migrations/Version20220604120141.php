<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604120141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pokemon ADD type1_id INT NOT NULL');
        $this->addSql('ALTER TABLE pokemon ADD type2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F3BFAFA3E1 FOREIGN KEY (type1_id) REFERENCES pokemon_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F3AD1A0C0F FOREIGN KEY (type2_id) REFERENCES pokemon_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_62DC90F3BFAFA3E1 ON pokemon (type1_id)');
        $this->addSql('CREATE INDEX IDX_62DC90F3AD1A0C0F ON pokemon (type2_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pokemon DROP CONSTRAINT FK_62DC90F3BFAFA3E1');
        $this->addSql('ALTER TABLE pokemon DROP CONSTRAINT FK_62DC90F3AD1A0C0F');
        $this->addSql('DROP INDEX IDX_62DC90F3BFAFA3E1');
        $this->addSql('DROP INDEX IDX_62DC90F3AD1A0C0F');
        $this->addSql('ALTER TABLE pokemon DROP type1_id');
        $this->addSql('ALTER TABLE pokemon DROP type2_id');
    }
}
