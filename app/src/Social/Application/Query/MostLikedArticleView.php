<?php

declare(strict_types=1);

namespace App\Social\Application\Query;

class MostLikedArticleView
{
    public function __construct(
        public readonly int $id,
        public readonly int $likeCount,
    ) {
    }
}
