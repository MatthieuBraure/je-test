<?php

declare(strict_types=1);

namespace App\Consulting\Application;

interface ArticleLikeCounter
{
    /**
     * @param int[] $articleIds
     *
     * @return array<int, int> mapping articleId => likeCount
     */
    public function countByIds(array $articleIds): array;
}
