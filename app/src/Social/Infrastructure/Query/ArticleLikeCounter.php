<?php

declare(strict_types=1);

namespace App\Social\Infrastructure\Query;

use App\Social\Application\Query\ArticleLikeCounter as LikeArticleInterface;
use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Connection;

class ArticleLikeCounter implements LikeArticleInterface
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function countByArticle(int $articleId): int
    {
        $sql = <<< 'SQL'
            SELECT COUNT(articleId) as likeCount
            FROM `like`
            WHERE articleId = :articleId
        SQL;
        $data = $this->connection->executeQuery(
            $sql,
            ['articleId' => $articleId],
        )->fetchAssociative();

        return (int) $data['likeCount'];
    }

    public function countByIds(array $articleIds): array
    {
        $sql = <<< 'SQL'
            SELECT articleId, COUNT(articleId) as likeCount
            FROM `like`
            WHERE articleId IN (:articleIds)
            GROUP BY articleId
        SQL;
        $data = $this->connection->executeQuery(
            $sql,
            ['articleIds' => $articleIds],
            ['articleIds' => ArrayParameterType::INTEGER],
        )->fetchAllAssociative();

        $results = [];
        foreach ($data as $rawArticle) {
            $results[(int) $rawArticle['articleId']] = (int) $rawArticle['likeCount'];
        }

        return $results;
    }
}
