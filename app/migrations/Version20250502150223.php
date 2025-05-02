<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250502150223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create logEntry table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE log_entry (
                id INT AUTO_INCREMENT NOT NULL,
                entityClass VARCHAR(255) NOT NULL,
                entityId VARCHAR(255) NOT NULL,
                action VARCHAR(50) NOT NULL,
                userId INT NOT NULL,
                loggedAt DATETIME NOT NULL,
                data LONGTEXT NOT NULL,
                PRIMARY KEY(id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE log_entry');
    }
}
