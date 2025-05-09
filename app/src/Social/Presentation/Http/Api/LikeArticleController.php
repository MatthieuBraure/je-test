<?php

declare(strict_types=1);

namespace App\Social\Presentation\Http\Api;

use App\Core\Domain\Command\CommandBus;
use App\Core\Domain\Exception\ArticleNotFound;
use App\Core\Domain\Model\User;
use App\Social\Application\Command\LikeArticle\LikeArticle;
use App\Social\Application\Query\ArticleLikeCounter as LikeArticleQuery;
use App\Social\Domain\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeArticleController extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly ArticleRepository $articleRepository,
    ) {
    }

    #[Route('/api/v1/social/article/{articleId}/like', name: 'social.article.like', methods: ['POST'])]
    public function __invoke(int $articleId, LikeArticleQuery $query): Response
    {
        try {
            $article = $this->articleRepository->getPublished($articleId);

            /** @var User $user */
            $user = $this->getUser();

            $command = new LikeArticle($articleId, $user->getId());
            $this->commandBus->handle($command);

            $likeCount = $query->countByArticle($articleId);

            return new Response(content: (string) $likeCount, status: Response::HTTP_OK);
        } catch (ArticleNotFound $articleNotFound) {
            return new Response(
                content: $articleNotFound->getMessage(),
                status: $articleNotFound->getCode(),
            );
        }
    }
}
