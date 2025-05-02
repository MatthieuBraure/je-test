<?php

declare(strict_types=1);

namespace App\Consulting\Application\Port;

interface ArticleLikePermission
{
    public function canLike(int $articleId, int $userId): bool;
}
