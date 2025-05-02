<?php

declare(strict_types=1);

namespace App\Social\Domain\Repository;

use App\Social\Domain\Model\Article;
use App\Social\Domain\Model\Like;
use App\Social\Domain\Model\User;

interface LikeRepository
{
    public function get(Article $article, User $user): ?Like;

    public function save(Like $like): void;

    public function delete(Like $like): void;
}
