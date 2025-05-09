<?php

declare(strict_types=1);

namespace App\Editorial\Presentation\Factory;

use App\Core\Application\Port\ArticleLikeCounter;
use App\Editorial\Domain\Model\Article;
use App\Editorial\Presentation\ViewModel\ArticleWithLikeView;

readonly class ArticleWithSocialViewFactory
{
    public function __construct(
        private ArticleLikeCounter $articleLikeCounter,
    ) {
    }

    public function create(Article $article): ArticleWithLikeView
    {
        return new ArticleWithLikeView(
            id: $article->id(),
            title: $article->title(),
            content: $article->content(),
            user: $article->user(),
            releaseDate: $article->releaseDate(),
            status: $article->status(),
            likeCount: $this->articleLikeCounter->countByArticle($article->id()),
        );
    }
}
