<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240618091816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fortune_cookie ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE fortune_cookie ADD CONSTRAINT FK_F8D8B4877E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F8D8B4877E3C61F9 ON fortune_cookie (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fortune_cookie DROP FOREIGN KEY FK_F8D8B4877E3C61F9');
        $this->addSql('DROP INDEX IDX_F8D8B4877E3C61F9 ON fortune_cookie');
        $this->addSql('ALTER TABLE fortune_cookie DROP owner_id');
    }
}
