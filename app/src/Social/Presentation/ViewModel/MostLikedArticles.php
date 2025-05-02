<?php

declare(strict_types=1);

namespace App\Social\Presentation\ViewModel;

use App\Social\Application\Query\MostLikedArticleView;

class MostLikedArticles implements \JsonSerializable
{
    /** @param array<int, MostLikedArticleView> $articles */
    public function __construct(
        private readonly array $articles,
        private readonly int $currentPage,
    ) {
    }

    /**
     * @return array{items: array<int, MostLikedArticleView>, page: int}
     */
    public function jsonSerialize(): array
    {
        return [
            'items' => $this->articles,
            'page' => $this->currentPage,
        ];
    }
}
