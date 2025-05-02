<?php

declare(strict_types=1);

namespace App\Social\Infrastructure\Query;

use App\Social\Application\Query\MostLikedArticles as MostLikedArticlesQuery;
use App\Social\Application\Query\MostLikedArticleView;
use App\Social\Domain\Repository\LikeRepository;

readonly class MostLikedArticles implements MostLikedArticlesQuery
{
    public function __construct(private LikeRepository $likeRepository)
    {
    }

    /**
     * @return array<int, MostLikedArticleView>
     */
    public function get(int $page, int $itemPerPage): array
    {
        return $this->likeRepository->getMostLikedArticles($page, $itemPerPage);
    }
}
