<?php

declare(strict_types=1);

namespace App\Social\Application\Command\UnLikeArticle;

use App\Core\Application\Command\CommandHandler;
use App\Core\Domain\Event\EventDispatcher;
use App\Social\Domain\Event\ArticleUnliked;
use App\Social\Domain\Repository\ArticleRepository;
use App\Social\Domain\Repository\LikeRepository;
use App\Social\Domain\Repository\UserRepository;

class UnLikeArticleHandler implements CommandHandler
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly UserRepository $userRepository,
        private readonly LikeRepository $likeRepository,
        private readonly EventDispatcher $eventDispatcher,
    ) {
    }

    public function __invoke(UnLikeArticle $command): void
    {
        $article = $this->articleRepository->getPublished($command->articleId());
        $user = $this->userRepository->get($command->userId());

        $like = $this->likeRepository->get($article, $user);
        if (null === $like) {
            return;
        }
        $this->likeRepository->delete($like);
        $this->eventDispatcher->dispatch(new ArticleUnliked(
            userId: $user->id(),
            articleId: $article->id(),
        ));
    }
}
