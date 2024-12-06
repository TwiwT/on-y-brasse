<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241206092731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brew_boiling (id SERIAL NOT NULL, brew_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_590FA0311DB7C47A ON brew_boiling (brew_id_id)');
        $this->addSql('CREATE TABLE brew_bottling (id SERIAL NOT NULL, brew_id_id INT NOT NULL, sugar DOUBLE PRECISION NOT NULL, details TEXT DEFAULT NULL, final_volume DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5CD884141DB7C47A ON brew_bottling (brew_id_id)');
        $this->addSql('CREATE TABLE brew_fermentation (id SERIAL NOT NULL, brew_id_id INT NOT NULL, duration INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C33A147D1DB7C47A ON brew_fermentation (brew_id_id)');
        $this->addSql('CREATE TABLE brew_history (id SERIAL NOT NULL, brew_id_id INT DEFAULT NULL, note TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8C2EF0BD1DB7C47A ON brew_history (brew_id_id)');
        $this->addSql('CREATE TABLE brew_hopping (id SERIAL NOT NULL, brew_id_id INT NOT NULL, hop_id_id INT NOT NULL, weight INT NOT NULL, add_at VARCHAR(255) NOT NULL, sort INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8A40E2AB1DB7C47A ON brew_hopping (brew_id_id)');
        $this->addSql('CREATE INDEX IDX_8A40E2ABA0AF8646 ON brew_hopping (hop_id_id)');
        $this->addSql('CREATE TABLE brew_mashing (id SERIAL NOT NULL, brew_id_id INT NOT NULL, duration INT NOT NULL, details TEXT NOT NULL, water DOUBLE PRECISION NOT NULL, water_rinsing DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_307FA9DC1DB7C47A ON brew_mashing (brew_id_id)');
        $this->addSql('CREATE TABLE brew_mashing_grain (id SERIAL NOT NULL, mashing_id_id INT NOT NULL, weight INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FEE291846FA288C6 ON brew_mashing_grain (mashing_id_id)');
        $this->addSql('CREATE TABLE flavor (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE grain (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, ebc INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE grain_stock (id SERIAL NOT NULL, grain_id_id INT NOT NULL, bought_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, weight DOUBLE PRECISION NOT NULL, remaining_weight DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CF2D6562FB5FAD55 ON grain_stock (grain_id_id)');
        $this->addSql('COMMENT ON COLUMN grain_stock.bought_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE hop (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, acid_alpha DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE hop_flavor (hop_id INT NOT NULL, flavor_id INT NOT NULL, PRIMARY KEY(hop_id, flavor_id))');
        $this->addSql('CREATE INDEX IDX_D64AFFBEBC3870B6 ON hop_flavor (hop_id)');
        $this->addSql('CREATE INDEX IDX_D64AFFBEFDDA6450 ON hop_flavor (flavor_id)');
        $this->addSql('CREATE TABLE hop_stock (id SERIAL NOT NULL, hop_id_id INT NOT NULL, bought_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, weight DOUBLE PRECISION NOT NULL, remaining_weight DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_94DD4E71A0AF8646 ON hop_stock (hop_id_id)');
        $this->addSql('COMMENT ON COLUMN hop_stock.bought_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE yeast (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, flocculation INT NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE brew_boiling ADD CONSTRAINT FK_590FA0311DB7C47A FOREIGN KEY (brew_id_id) REFERENCES brew (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brew_bottling ADD CONSTRAINT FK_5CD884141DB7C47A FOREIGN KEY (brew_id_id) REFERENCES brew (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brew_fermentation ADD CONSTRAINT FK_C33A147D1DB7C47A FOREIGN KEY (brew_id_id) REFERENCES brew (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brew_history ADD CONSTRAINT FK_8C2EF0BD1DB7C47A FOREIGN KEY (brew_id_id) REFERENCES brew (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brew_hopping ADD CONSTRAINT FK_8A40E2AB1DB7C47A FOREIGN KEY (brew_id_id) REFERENCES brew (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brew_hopping ADD CONSTRAINT FK_8A40E2ABA0AF8646 FOREIGN KEY (hop_id_id) REFERENCES hop (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brew_mashing ADD CONSTRAINT FK_307FA9DC1DB7C47A FOREIGN KEY (brew_id_id) REFERENCES brew (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brew_mashing_grain ADD CONSTRAINT FK_FEE291846FA288C6 FOREIGN KEY (mashing_id_id) REFERENCES brew_mashing (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE grain_stock ADD CONSTRAINT FK_CF2D6562FB5FAD55 FOREIGN KEY (grain_id_id) REFERENCES grain (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hop_flavor ADD CONSTRAINT FK_D64AFFBEBC3870B6 FOREIGN KEY (hop_id) REFERENCES hop (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hop_flavor ADD CONSTRAINT FK_D64AFFBEFDDA6450 FOREIGN KEY (flavor_id) REFERENCES flavor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hop_stock ADD CONSTRAINT FK_94DD4E71A0AF8646 FOREIGN KEY (hop_id_id) REFERENCES hop (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brew ADD target_volume DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE brew ADD alcool DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE brew ADD density_initial INT DEFAULT NULL');
        $this->addSql('ALTER TABLE brew ADD density_final INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE brew_boiling DROP CONSTRAINT FK_590FA0311DB7C47A');
        $this->addSql('ALTER TABLE brew_bottling DROP CONSTRAINT FK_5CD884141DB7C47A');
        $this->addSql('ALTER TABLE brew_fermentation DROP CONSTRAINT FK_C33A147D1DB7C47A');
        $this->addSql('ALTER TABLE brew_history DROP CONSTRAINT FK_8C2EF0BD1DB7C47A');
        $this->addSql('ALTER TABLE brew_hopping DROP CONSTRAINT FK_8A40E2AB1DB7C47A');
        $this->addSql('ALTER TABLE brew_hopping DROP CONSTRAINT FK_8A40E2ABA0AF8646');
        $this->addSql('ALTER TABLE brew_mashing DROP CONSTRAINT FK_307FA9DC1DB7C47A');
        $this->addSql('ALTER TABLE brew_mashing_grain DROP CONSTRAINT FK_FEE291846FA288C6');
        $this->addSql('ALTER TABLE grain_stock DROP CONSTRAINT FK_CF2D6562FB5FAD55');
        $this->addSql('ALTER TABLE hop_flavor DROP CONSTRAINT FK_D64AFFBEBC3870B6');
        $this->addSql('ALTER TABLE hop_flavor DROP CONSTRAINT FK_D64AFFBEFDDA6450');
        $this->addSql('ALTER TABLE hop_stock DROP CONSTRAINT FK_94DD4E71A0AF8646');
        $this->addSql('DROP TABLE brew_boiling');
        $this->addSql('DROP TABLE brew_bottling');
        $this->addSql('DROP TABLE brew_fermentation');
        $this->addSql('DROP TABLE brew_history');
        $this->addSql('DROP TABLE brew_hopping');
        $this->addSql('DROP TABLE brew_mashing');
        $this->addSql('DROP TABLE brew_mashing_grain');
        $this->addSql('DROP TABLE flavor');
        $this->addSql('DROP TABLE grain');
        $this->addSql('DROP TABLE grain_stock');
        $this->addSql('DROP TABLE hop');
        $this->addSql('DROP TABLE hop_flavor');
        $this->addSql('DROP TABLE hop_stock');
        $this->addSql('DROP TABLE yeast');
        $this->addSql('ALTER TABLE brew DROP target_volume');
        $this->addSql('ALTER TABLE brew DROP alcool');
        $this->addSql('ALTER TABLE brew DROP density_initial');
        $this->addSql('ALTER TABLE brew DROP density_final');
    }
}
