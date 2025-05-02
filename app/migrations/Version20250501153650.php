<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250501153650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create like table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `like` (
                `id` int NOT NULL AUTO_INCREMENT, 
                `articleId` int NOT NULL, 
                `userId` int NOT NULL, 
                `createdAt` datetime NOT NULL, 
                PRIMARY KEY (id), 
                KEY IDX_4A3E1E7B7A7E4B6A (articleId), 
                KEY IDX_4A3E1E7B7A7E4B6B (userId), 
                UNIQUE INDEX UNIQ_LIKE_ARTICLE_USER (articleId, userId),
                CONSTRAINT FK_LIKE_ARTICLE FOREIGN KEY (articleId) REFERENCES article (id) ON DELETE RESTRICT ON UPDATE RESTRICT, 
                CONSTRAINT FK_LIKE_USER FOREIGN KEY (userId) REFERENCES user (id) ON DELETE RESTRICT ON UPDATE RESTRICT
          )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `like`');
    }
}
