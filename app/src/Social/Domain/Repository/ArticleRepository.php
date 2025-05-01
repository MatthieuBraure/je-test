<?php

declare(strict_types=1);

namespace App\Social\Domain\Repository;

use App\Social\Domain\Model\Article;

interface ArticleRepository
{
    public function getPublished(int $articleId): Article;
}
