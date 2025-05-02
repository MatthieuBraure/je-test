<?php

declare(strict_types=1);

namespace App\Social\Domain\Event;

use App\Core\Application\Event\Event;

class ArticleLiked implements Event
{
    public function __construct(
        public int $userId,
        public int $articleId,
    ) {
    }
}
