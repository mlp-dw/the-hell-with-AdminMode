<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728120708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quizz DROP FOREIGN KEY FK_7C77973D7A7B643');
        $this->addSql('DROP TABLE result');
        $this->addSql('DROP INDEX IDX_7C77973D7A7B643 ON quizz');
        $this->addSql('ALTER TABLE quizz ADD result LONGTEXT NOT NULL, DROP result_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quizz ADD result_id INT NOT NULL, DROP result');
        $this->addSql('ALTER TABLE quizz ADD CONSTRAINT FK_7C77973D7A7B643 FOREIGN KEY (result_id) REFERENCES result (id)');
        $this->addSql('CREATE INDEX IDX_7C77973D7A7B643 ON quizz (result_id)');
    }
}
