<?php

declare(strict_types=1);

namespace App\Social\Application\Command\UnLikeArticle;

use App\Core\Application\Command\Command;

final class UnLikeArticle implements Command
{
    public function __construct(
        private readonly int $articleId,
        private readonly int $userId,
    ) {
    }

    public function articleId(): int
    {
        return $this->articleId;
    }

    public function userId(): int
    {
        return $this->userId;
    }
}
