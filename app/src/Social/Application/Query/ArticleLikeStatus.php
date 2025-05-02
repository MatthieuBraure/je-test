<?php

declare(strict_types=1);

namespace App\Social\Application\Query;

interface ArticleLikeStatus
{
    public function hasLiked(int $articleId, int $userId): bool;
}
