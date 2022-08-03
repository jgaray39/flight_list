<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220803070657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flight ADD city_start_id INT NOT NULL, ADD city_end_id INT NOT NULL');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60EE7E581FD FOREIGN KEY (city_start_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E17F1C4E0 FOREIGN KEY (city_end_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_C257E60EE7E581FD ON flight (city_start_id)');
        $this->addSql('CREATE INDEX IDX_C257E60E17F1C4E0 ON flight (city_end_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flight DROP FOREIGN KEY FK_C257E60EE7E581FD');
        $this->addSql('ALTER TABLE flight DROP FOREIGN KEY FK_C257E60E17F1C4E0');
        $this->addSql('DROP INDEX IDX_C257E60EE7E581FD ON flight');
        $this->addSql('DROP INDEX IDX_C257E60E17F1C4E0 ON flight');
        $this->addSql('ALTER TABLE flight DROP city_start_id, DROP city_end_id');
    }
}
