<?php

declare(strict_types=1);

namespace App\Social\Application\Query;

interface MostLikedArticles
{
    /**
     * @return array<int, MostLikedArticleView>
     */
    public function get(int $page, int $itemPerPage): array;
}
