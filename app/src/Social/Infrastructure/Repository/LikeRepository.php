<?php

declare(strict_types=1);

namespace App\Social\Infrastructure\Repository;

use App\Social\Application\Query\MostLikedArticleView;
use App\Social\Domain\Model\Article;
use App\Social\Domain\Model\Like;
use App\Social\Domain\Model\User;
use App\Social\Domain\Repository\LikeRepository as LikeRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;

class LikeRepository implements LikeRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function get(Article $article, User $user): ?Like
    {
        $sql = <<< 'SQL'
            SELECT id, articleId, userId, createdAt
            FROM `like` 
            WHERE articleId = :articleId
            AND userId = :userId
        SQL;

        $data = $this->connection->executeQuery($sql, ['articleId' => $article->id(), 'userId' => $user->id()])->fetchAssociative();
        if (!$data) {
            return null;
        }

        return Like::create(
            article: $article,
            user: $user,
            id: (int) $data['id'],
            createdAt: new \DateTimeImmutable($data['createdAt']),
        );
    }

    /**
     * @return array<int, MostLikedArticleView>
     */
    public function getMostLikedArticles(int $page, int $itemPerPage): array
    {
        $sql = <<< 'SQL'
            SELECT articleId, count(id) as nbLikes
                FROM `like`
                GROUP BY articleId
                ORDER BY nbLikes DESC, articleId DESC
                LIMIT :itemPerPage
                OFFSET :firstResultOffset
        SQL;

        $data = $this->connection->executeQuery($sql, [
            'itemPerPage' => $itemPerPage,
            'firstResultOffset' => ($page - 1) * $itemPerPage,
        ], [
            'itemPerPage' => ParameterType::INTEGER,
            'firstResultOffset' => ParameterType::INTEGER,
        ])->fetchAllAssociative();

        $results = [];
        foreach ($data as $raw) {
            $results[] = new MostLikedArticleView(
                (int) $raw['articleId'],
                (int) $raw['nbLikes'],
            );
        }

        return $results;
    }

    public function resetLikesFor(Article $article): void
    {
        $this->connection->delete(
            '`like`',
            [
                'articleId' => $article->id(),
            ],
        );
    }

    public function save(Like $like): void
    {
        $this->connection->insert(
            '`like`',
            [
                'articleId' => $like->article()->id(),
                'userId' => $like->user()->id(),
                'createdAt' => $like->createdAt()->format(DATE_ATOM),
            ],
        );
    }

    public function delete(Like $like): void
    {
        $this->connection->delete(
            '`like`',
            [
                'articleId' => $like->article()->id(),
                'userId' => $like->user()->id(),
            ],
        );
    }
}
