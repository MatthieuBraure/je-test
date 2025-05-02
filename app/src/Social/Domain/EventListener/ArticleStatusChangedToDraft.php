<?php

declare(strict_types=1);

namespace App\Social\Domain\EventListener;

use App\Core\Application\Event\EventSubscriber;
use App\Editorial\Domain\Event\ArticleStatusChangedToDraft as ArticleStatusChangedToDraftEvent;
use App\Social\Domain\Repository\ArticleRepository;
use App\Social\Domain\Repository\LikeRepository;

class ArticleStatusChangedToDraft implements EventSubscriber
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly LikeRepository $likeRepository,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ArticleStatusChangedToDraftEvent::class => 'onArticleStatusChangedToDraft',
        ];
    }

    public function onArticleStatusChangedToDraft(ArticleStatusChangedToDraftEvent $event): void
    {
        $article = $this->articleRepository->get($event->articleId);
        $this->likeRepository->resetLikesFor($article);
    }
}
