<?php

declare(strict_types=1);

namespace App\Social\Infrastructure\Adapter;

use App\Consulting\Application\Port\ArticleLikeStatusProvider;
use App\Social\Application\Query\ArticleLikeStatus as ArticleLikeStatusInterface;

class ArticleLikeStatus implements ArticleLikeStatusProvider
{
    public function __construct(
        private readonly ArticleLikeStatusInterface $likeArticle,
    ) {
    }

    public function hasLiked(int $articleId, int $userId): bool
    {
        return $this->likeArticle->hasLiked($articleId, $userId);
    }
}
