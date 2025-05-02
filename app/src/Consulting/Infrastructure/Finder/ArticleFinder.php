<?php

declare(strict_types=1);

namespace App\Consulting\Infrastructure\Finder;

use App\Consulting\Application\ArticleLikeCounter;
use App\Consulting\Application\ArticleLikePermission;
use App\Consulting\Domain\Finder\ArticleFinder as ArticleFinderInterface;
use App\Consulting\Domain\Model\Article;
use App\Consulting\Domain\Model\User;
use App\Editorial\Domain\Model\Status;
use App\Social\Application\Query\ArticleLikeStatus;
use Doctrine\DBAL\Connection;

class ArticleFinder implements ArticleFinderInterface
{
    public function __construct(
        private readonly Connection $connection,
        private readonly ArticleLikeCounter $articleLikeCounter,
        private readonly ArticleLikeStatus $articleLikeStatus,
        private readonly ArticleLikePermission $articleLikePermission,
    ) {
    }

    public function findAll(int $userId): array
    {
        $sql = <<< 'SQL'
            SELECT a.id as id,
                   a.title as title,
                   a.content as content,
                   a.userId as userId,
                   a.releaseDate as releaseDate,
                   u.firstname as userFirstName,
                   u.lastname as userLastName
            FROM article a
            JOIN user u ON a.userId = u.id
            WHERE status = :published
            ORDER BY releaseDate DESC
        SQL;
        $data = $this->connection->executeQuery($sql, ['published' => Status::PUBLISHED])->fetchAllAssociative();

        $results = [];

        $articleIds = array_map(fn ($raw) => (int) $raw['id'], $data);
        $likeCounts = $this->articleLikeCounter->countByIds($articleIds);
        foreach ($data as $rawArticle) {
            $releaseDate = $rawArticle['releaseDate'];
            if (\is_string($releaseDate)) {
                $releaseDate = new \DateTimeImmutable($releaseDate);
            }

            /** @var array<string|int> $data */
            $id = (int) $rawArticle['id'];
            $article = new Article(
                id: $id,
                title: (string) $rawArticle['title'],
                content: (string) $rawArticle['content'],
                user: new User($rawArticle['userId'], $rawArticle['userFirstName'], $rawArticle['userLastName']),
                likeCount: $likeCounts[$id] ?? 0,
                hasLiked: $this->articleLikeStatus->hasLiked($id, $userId),
                canLike: $this->articleLikePermission->canLike($id, $userId),
                releaseDate: $releaseDate,
            );

            $results[] = $article;
        }

        return $results;
    }
}
