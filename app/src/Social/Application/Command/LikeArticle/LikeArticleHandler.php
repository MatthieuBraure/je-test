<?php

declare(strict_types=1);

namespace App\Social\Application\Command\LikeArticle;

use App\Core\Application\Command\CommandHandler;
use App\Core\Domain\Event\EventDispatcher;
use App\Social\Domain\Event\ArticleLiked;
use App\Social\Domain\Exception\InvalidLikeCreation;
use App\Social\Domain\Model\Like;
use App\Social\Domain\Repository\ArticleRepository;
use App\Social\Domain\Repository\LikeRepository;
use App\Social\Domain\Repository\UserRepository;

class LikeArticleHandler implements CommandHandler
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly UserRepository $userRepository,
        private readonly LikeRepository $likeRepository,
        private readonly EventDispatcher $eventDispatcher,
    ) {
    }

    public function __invoke(LikeArticle $command): void
    {
        $article = $this->articleRepository->getPublished($command->articleId());
        $user = $this->userRepository->get($command->userId());

        if ($article->user()->id() === $user->id()) {
            throw InvalidLikeCreation::cannotLikeYourOwnArticle();
        }

        if (null !== $this->likeRepository->get($article, $user)) {
            throw InvalidLikeCreation::cannotLikeTwice();
        }

        $like = Like::create($article, $user);
        $this->likeRepository->save($like);

        $this->eventDispatcher->dispatch(new ArticleLiked(
            userId: $user->id(),
            articleId: $article->id(),
        ));
    }
}
