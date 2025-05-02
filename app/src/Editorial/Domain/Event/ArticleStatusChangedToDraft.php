<?php

declare(strict_types=1);

namespace App\Editorial\Domain\Event;

use App\Core\Application\Event\Event;

class ArticleStatusChangedToDraft implements Event
{
    public function __construct(
        public readonly int $articleId,
    ) {
    }
}
