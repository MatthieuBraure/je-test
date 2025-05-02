<?php

declare(strict_types=1);

namespace App\Tests\Social\Application\Command\LikeArticle;

use App\Social\Application\Command\LikeArticle\LikeArticle;
use App\Social\Application\Command\LikeArticle\LikeArticleHandler;
use App\Social\Domain\Exception\InvalidLikeCreation;
use App\Social\Domain\Model\Article;
use App\Social\Domain\Model\Like;
use App\Social\Domain\Model\User;
use App\Social\Domain\Repository\ArticleRepository;
use App\Social\Domain\Repository\LikeRepository;
use App\Social\Domain\Repository\UserRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LikeArticleHandlerTest extends TestCase
{
    /** @var ArticleRepository&MockObject */
    private ArticleRepository $articleRepository;
    /** @var UserRepository&MockObject */
    private UserRepository $userRepository;
    /** @var LikeRepository&MockObject */
    private LikeRepository $likeRepository;
    private LikeArticleHandler $handler;

    protected function setUp(): void
    {
        $this->articleRepository = $this->createMock(ArticleRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->likeRepository = $this->createMock(LikeRepository::class);

        $this->handler = new LikeArticleHandler(
            $this->articleRepository,
            $this->userRepository,
            $this->likeRepository,
        );
    }

    public function testUserCannotLikeOwnArticle(): void
    {
        $user = new User(1);
        $article = Article::create(id: 1, user: $user, isPublished: true);

        $this->articleRepository->method('getPublished')->willReturn($article);
        $this->userRepository->method('get')->willReturn($user);

        $this->expectException(InvalidLikeCreation::class);

        $command = new LikeArticle($article->id(), $user->id());
        ($this->handler)($command);
    }

    public function testUserCannotLikeTwice(): void
    {
        $user = new User(1);
        $author = new User(2);
        $article = Article::create(id: 1, user: $author, isPublished: true);
        $like = Like::create($article, $user);

        $this->articleRepository->method('getPublished')->willReturn($article);
        $this->userRepository->method('get')->willReturn($user);
        $this->likeRepository->method('get')->willReturn($like);

        $this->expectException(InvalidLikeCreation::class);

        $command = new LikeArticle($article->id(), $user->id());
        ($this->handler)($command);
    }

    public function testUserCanLikeArticle(): void
    {
        $user = new User(1);
        $author = new User(2);
        $article = Article::create(id: 1, user: $author, isPublished: true);

        $this->articleRepository->method('getPublished')->willReturn($article);
        $this->userRepository->method('get')->willReturn($user);
        $this->likeRepository->method('get')->willReturn(null);

        $this->likeRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Like::class));

        $command = new LikeArticle($article->id(), $user->id());
        $this->handler->__invoke($command);
    }
}
