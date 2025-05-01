<?php

declare(strict_types=1);

namespace App\Social\Infrastructure\Repository;

use App\Core\Domain\Exception\ArticleNotFound;
use App\Social\Domain\Model\Article;
use App\Social\Domain\Repository\ArticleRepository as ArticleRepositoryInterface;
use App\Social\Domain\Repository\UserRepository;
use Doctrine\DBAL\Connection;

class ArticleRepository implements ArticleRepositoryInterface
{
    private const STATUS_PUBLISHED = 'published';

    public function __construct(
        private readonly Connection $connection,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function getPublished(int $articleId): Article
    {
        $sql = <<< 'SQL'
            SELECT * 
            FROM article 
            WHERE id = :articleId
            AND status = :publishedStatus
        SQL;

        $data = $this->connection->executeQuery($sql, ['articleId' => $articleId, 'publishedStatus' => self::STATUS_PUBLISHED])->fetchAssociative();
        if (!$data) {
            throw ArticleNotFound::create($articleId);
        }

        return Article::create(
            id: (int) $data['id'],
            user: $this->userRepository->get((int) $data['userId']),
            isPublished: true,
        );
    }
}
