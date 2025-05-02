<?php

declare(strict_types=1);

namespace App\Social\Infrastructure\Adapter;

use App\Consulting\Application\Port\ArticleLikePermission as ArticleLikePermissionInterface;
use App\Social\Infrastructure\Checker\ArticleLikePermission as ArticleLikePermissionChecker;

class ArticleLikePermission implements ArticleLikePermissionInterface
{
    public function __construct(
        private readonly ArticleLikePermissionChecker $likeArticle,
    ) {
    }

    public function canLike(int $articleId, int $userId): bool
    {
        return $this->likeArticle->canLike($articleId, $userId);
    }
}
