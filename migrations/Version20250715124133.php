<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250715124133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, descritpion LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project ADD type_id INT NOT NULL, ADD project_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEC54C8C93 FOREIGN KEY (type_id) REFERENCES project_type (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEDA896A19 FOREIGN KEY (project_category_id) REFERENCES project_category (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEC54C8C93 ON project (type_id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEDA896A19 ON project (project_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEDA896A19');
        $this->addSql('DROP TABLE project_category');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEC54C8C93');
        $this->addSql('DROP INDEX IDX_2FB3D0EEC54C8C93 ON project');
        $this->addSql('DROP INDEX IDX_2FB3D0EEDA896A19 ON project');
        $this->addSql('ALTER TABLE project DROP type_id, DROP project_category_id');
    }
}
