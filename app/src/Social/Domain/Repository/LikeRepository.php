<?php

declare(strict_types=1);

namespace App\Social\Domain\Repository;

use App\Social\Application\Query\MostLikedArticleView;
use App\Social\Domain\Model\Article;
use App\Social\Domain\Model\Like;
use App\Social\Domain\Model\User;

interface LikeRepository
{
    public function get(Article $article, User $user): ?Like;

    /**
     * @return array<int, MostLikedArticleView>
     */
    public function getMostLikedArticles(int $page, int $itemPerPage): array;

    public function resetLikesFor(Article $article): void;

    public function save(Like $like): void;

    public function delete(Like $like): void;
}
