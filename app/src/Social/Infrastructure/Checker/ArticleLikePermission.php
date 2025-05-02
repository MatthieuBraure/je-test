<?php

declare(strict_types=1);

namespace App\Social\Infrastructure\Checker;

use App\Core\Domain\Exception\ArticleNotFound;
use App\Social\Application\Checker\ArticleLikePermission as ArticleLikePermissionInterface;
use App\Social\Domain\Policy\CanLike;
use App\Social\Infrastructure\Repository\ArticleRepository;
use App\Social\Infrastructure\Repository\UserRepository;

class ArticleLikePermission implements ArticleLikePermissionInterface
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly UserRepository $userRepository,
        private readonly CanLike $canLike,
    ) {
    }

    public function canLike(int $articleId, int $userId): bool
    {
        try {
            $article = $this->articleRepository->getPublished($articleId);
            $user = $this->userRepository->get($userId);

            return $this->canLike->canLike($article, $user);
        } catch (ArticleNotFound) {
            return false;
        }
    }
}
