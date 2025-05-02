<?php

declare(strict_types=1);

namespace App\Core\Application\Port;

interface ArticleLikeCounter
{
    /**
     * @param int[] $articleIds
     *
     * @return array<int, int> mapping articleId => likeCount
     */
    public function countByIds(array $articleIds): array;
}
