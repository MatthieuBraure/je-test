<?php

declare(strict_types=1);

namespace App\Social\Application\Query;

interface ArticleLikeCounter
{
    public function countByArticle(int $articleId): int;

    /**
     * @param int[] $articleIds
     *
     * @return array<int, int> mapping articleId => likeCount
     */
    public function countByIds(array $articleIds): array;
}
