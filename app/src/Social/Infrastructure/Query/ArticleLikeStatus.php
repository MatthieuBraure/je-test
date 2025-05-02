<?php

declare(strict_types=1);

namespace App\Social\Infrastructure\Query;

use App\Social\Application\Query\ArticleLikeStatus as ArticleLikeStatusInterface;
use Doctrine\DBAL\Connection;

class ArticleLikeStatus implements ArticleLikeStatusInterface
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function hasLiked(int $articleId, int $userId): bool
    {
        $sql = <<< 'SQL'
            SELECT 1
            FROM `like`
            WHERE articleId = :articleId AND userId = :userId
        SQL;
        $data = $this->connection->executeQuery(
            $sql,
            ['articleId' => $articleId, 'userId' => $userId],
        )->fetchOne();

        return (bool) $data;
    }
}
