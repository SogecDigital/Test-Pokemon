<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231209105306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add pokemon and type table (and pokemon_type relationship table)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE greeting_id_seq CASCADE');
        $this->addSql('CREATE TABLE pokemon (id INT NOT NULL, name VARCHAR(255) NOT NULL, hp INT NOT NULL, attack INT NOT NULL, defense INT NOT NULL, sp_atk INT NOT NULL, sp_def INT NOT NULL, speed INT NOT NULL, generation SMALLINT NOT NULL, legendary BOOLEAN NOT NULL, total INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pokemon_type (pokemon_id INT NOT NULL, type_id INT NOT NULL, PRIMARY KEY(pokemon_id, type_id))');
        $this->addSql('CREATE INDEX IDX_B077296A2FE71C3E ON pokemon_type (pokemon_id)');
        $this->addSql('CREATE INDEX IDX_B077296AC54C8C93 ON pokemon_type (type_id)');
        $this->addSql('CREATE TABLE type (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8CDE57295E237E06 ON type (name)');
        $this->addSql('ALTER TABLE pokemon_type ADD CONSTRAINT FK_B077296A2FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pokemon_type ADD CONSTRAINT FK_B077296AC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE greeting_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE pokemon_type DROP CONSTRAINT FK_B077296A2FE71C3E');
        $this->addSql('ALTER TABLE pokemon_type DROP CONSTRAINT FK_B077296AC54C8C93');
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('DROP TABLE pokemon_type');
        $this->addSql('DROP TABLE type');
    }
}
