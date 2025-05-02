<?php

declare(strict_types=1);

namespace App\Social\Infrastructure\Repository;

use App\Social\Domain\Model\Article;
use App\Social\Domain\Model\Like;
use App\Social\Domain\Model\User;
use App\Social\Domain\Repository\LikeRepository as LikeRepositoryInterface;
use Doctrine\DBAL\Connection;

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
