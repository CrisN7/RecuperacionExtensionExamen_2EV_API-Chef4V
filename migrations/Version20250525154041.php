<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250525154041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, recipe_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, quantity DOUBLE PRECISION NOT NULL, unit VARCHAR(255) NOT NULL, INDEX IDX_6BAF787059D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nutrient_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, unit VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, recipe_id INT DEFAULT NULL, number_votes INT NOT NULL, rating_avg DOUBLE PRECISION NOT NULL, INDEX IDX_D889262259D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, number_dinner INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipes_nutrients (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, recipe_id INT DEFAULT NULL, quantity DOUBLE PRECISION NOT NULL, INDEX IDX_187DDBA3C54C8C93 (type_id), INDEX IDX_187DDBA359D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, recipe_id INT DEFAULT NULL, order_number INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_43B9FE3C59D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF787059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D889262259D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE recipes_nutrients ADD CONSTRAINT FK_187DDBA3C54C8C93 FOREIGN KEY (type_id) REFERENCES nutrient_type (id)');
        $this->addSql('ALTER TABLE recipes_nutrients ADD CONSTRAINT FK_187DDBA359D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF787059D8A214');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D889262259D8A214');
        $this->addSql('ALTER TABLE recipes_nutrients DROP FOREIGN KEY FK_187DDBA3C54C8C93');
        $this->addSql('ALTER TABLE recipes_nutrients DROP FOREIGN KEY FK_187DDBA359D8A214');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C59D8A214');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE nutrient_type');
        $this->addSql('DROP TABLE rating');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipes_nutrients');
        $this->addSql('DROP TABLE step');
    }
}
