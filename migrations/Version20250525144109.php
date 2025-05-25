<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250525144109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF787054F853F8');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF787079E3E313');
        $this->addSql('ALTER TABLE nutrient_receta DROP FOREIGN KEY FK_D04E594627373320');
        $this->addSql('ALTER TABLE nutrient_receta DROP FOREIGN KEY FK_D04E594654F853F8');
        $this->addSql('ALTER TABLE receta_nutrient DROP FOREIGN KEY FK_633E17BD54F853F8');
        $this->addSql('ALTER TABLE receta_nutrient DROP FOREIGN KEY FK_633E17BD27373320');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C54F853F8');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C79E3E313');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE nutrient');
        $this->addSql('DROP TABLE nutrient_receta');
        $this->addSql('DROP TABLE receta');
        $this->addSql('DROP TABLE receta_nutrient');
        $this->addSql('DROP TABLE step');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, receta_id INT NOT NULL, receta_me_obligo_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_6BAF787079E3E313 (receta_me_obligo_id), INDEX IDX_6BAF787054F853F8 (receta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nutrient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, unidad_de_medida VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nutrient_receta (nutrient_id INT NOT NULL, receta_id INT NOT NULL, INDEX IDX_D04E594627373320 (nutrient_id), INDEX IDX_D04E594654F853F8 (receta_id), PRIMARY KEY(nutrient_id, receta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE receta (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE receta_nutrient (receta_id INT NOT NULL, nutrient_id INT NOT NULL, INDEX IDX_633E17BD27373320 (nutrient_id), INDEX IDX_633E17BD54F853F8 (receta_id), PRIMARY KEY(receta_id, nutrient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, receta_id INT DEFAULT NULL, receta_me_obligo_id INT DEFAULT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_43B9FE3C79E3E313 (receta_me_obligo_id), INDEX IDX_43B9FE3C54F853F8 (receta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF787054F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF787079E3E313 FOREIGN KEY (receta_me_obligo_id) REFERENCES receta (id)');
        $this->addSql('ALTER TABLE nutrient_receta ADD CONSTRAINT FK_D04E594627373320 FOREIGN KEY (nutrient_id) REFERENCES nutrient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nutrient_receta ADD CONSTRAINT FK_D04E594654F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE receta_nutrient ADD CONSTRAINT FK_633E17BD54F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE receta_nutrient ADD CONSTRAINT FK_633E17BD27373320 FOREIGN KEY (nutrient_id) REFERENCES nutrient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C54F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id)');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C79E3E313 FOREIGN KEY (receta_me_obligo_id) REFERENCES receta (id)');
    }
}
