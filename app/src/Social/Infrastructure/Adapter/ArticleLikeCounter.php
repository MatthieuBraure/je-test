<?php

declare(strict_types=1);

namespace App\Social\Infrastructure\Adapter;

use App\Core\Application\Port\ArticleLikeCounter as ConsultingArticleLikeCounter;
use App\Social\Application\Query\ArticleLikeCounter as ArticleLikeCounterQuery;

readonly class ArticleLikeCounter implements ConsultingArticleLikeCounter
{
    public function __construct(
        private ArticleLikeCounterQuery $likeArticle,
    ) {
    }

    public function countByIds(array $articleIds): array
    {
        return $this->likeArticle->countByIds($articleIds);
    }
}
