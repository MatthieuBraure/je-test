<?php

declare(strict_types=1);

namespace App\Consulting\Presentation\Factory;

use App\Consulting\Application\Port\ArticleLikePermission;
use App\Consulting\Application\Port\ArticleLikeStatusProvider;
use App\Consulting\Domain\Model\Article;
use App\Consulting\Presentation\ViewModel\ArticleWithSocialView;
use App\Core\Application\Port\ArticleLikeCounter;

readonly class ArticleWithSocialViewFactory
{
    public function __construct(
        private ArticleLikeCounter $articleLikeCounter,
        private ArticleLikeStatusProvider $articleLikeStatus,
        private ArticleLikePermission $articleLikePermission,
    ) {
    }

    public function create(Article $article, int $userId): ArticleWithSocialView
    {
        return new ArticleWithSocialView(
            id: $article->id(),
            title: $article->title(),
            content: $article->content(),
            user: $article->user(),
            likeCount: $this->articleLikeCounter->countByArticle($article->id()),
            hasLiked: $this->articleLikeStatus->hasLiked($article->id(), $userId),
            canLike: $this->articleLikePermission->canLike($article->id(), $userId),
            releaseDate: $article->releaseDate(),
        );
    }
}
