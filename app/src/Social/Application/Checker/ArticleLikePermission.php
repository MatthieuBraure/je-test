<?php

declare(strict_types=1);

namespace App\Social\Application\Checker;

interface ArticleLikePermission
{
    public function canLike(int $articleId, int $userId): bool;
}
