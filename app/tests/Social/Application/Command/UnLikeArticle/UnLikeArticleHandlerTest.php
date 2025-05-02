<?php

declare(strict_types=1);

namespace App\Tests\Social\Application\Command\UnLikeArticle;

use App\Core\Domain\Event\EventDispatcher;
use App\Social\Application\Command\UnLikeArticle\UnLikeArticle;
use App\Social\Application\Command\UnLikeArticle\UnLikeArticleHandler;
use App\Social\Domain\Model\Article;
use App\Social\Domain\Model\Like;
use App\Social\Domain\Model\User;
use App\Social\Domain\Repository\ArticleRepository;
use App\Social\Domain\Repository\LikeRepository;
use App\Social\Domain\Repository\UserRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UnLikeArticleHandlerTest extends TestCase
{
    /** @var ArticleRepository&MockObject */
    private ArticleRepository $articleRepository;
    /** @var UserRepository&MockObject */
    private UserRepository $userRepository;
    /** @var LikeRepository&MockObject */
    private LikeRepository $likeRepository;
    /** @var EventDispatcher&MockObject */
    private EventDispatcher $eventDispatcher;
    private UnLikeArticleHandler $handler;

    protected function setUp(): void
    {
        $this->articleRepository = $this->createMock(ArticleRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->likeRepository = $this->createMock(LikeRepository::class);
        $this->eventDispatcher = $this->createMock(EventDispatcher::class);

        $this->handler = new UnLikeArticleHandler(
            $this->articleRepository,
            $this->userRepository,
            $this->likeRepository,
            $this->eventDispatcher,
        );
    }

    public function testNothingHappensIfUserHasNotLikedArticle(): void
    {
        $user = new User(1);
        $author = new User(2);
        $article = Article::create(id: 1, user: $author, isPublished: true);

        $this->articleRepository->method('getPublished')->willReturn($article);
        $this->userRepository->method('get')->willReturn($user);
        $this->likeRepository->method('get')->willReturn(null);

        $this->likeRepository
            ->expects($this->never())
            ->method('delete');

        $command = new UnLikeArticle($article->id(), $user->id());
        $this->handler->__invoke($command);
    }

    public function testUserCanUnLikeArticle(): void
    {
        $user = new User(1);
        $author = new User(2);
        $article = Article::create(id: 1, user: $author, isPublished: true);

        $like = Like::create($article, $user);
        $this->articleRepository->method('getPublished')->willReturn($article);
        $this->userRepository->method('get')->willReturn($user);
        $this->likeRepository->method('get')->willReturn($like);

        $this->likeRepository
            ->expects($this->once())
            ->method('delete')
            ->with($this->isInstanceOf(Like::class));

        $command = new UnLikeArticle($article->id(), $user->id());
        $this->handler->__invoke($command);
    }
}
