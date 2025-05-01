<?php

declare(strict_types=1);

namespace App\Social\Application\Command\LikeArticle;

use App\Core\Application\Command\Command;

final class LikeArticle implements Command
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
