<?php

declare(strict_types=1);

namespace App\Consulting\Application\Port;

interface ArticleLikeStatusProvider
{
    public function hasLiked(int $articleId, int $userId): bool;
}
