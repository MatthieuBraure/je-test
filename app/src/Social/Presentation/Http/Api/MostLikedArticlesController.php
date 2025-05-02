<?php

declare(strict_types=1);

namespace App\Social\Presentation\Http\Api;

use App\Social\Application\Query\MostLikedArticles;
use App\Social\Presentation\ViewModel\MostLikedArticles as MostLikedArticlesView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MostLikedArticlesController extends AbstractController
{
    public function __construct(private readonly MostLikedArticles $mostLikedArticles)
    {
    }

    #[Route('/api/v1/social/article/most-liked', name: 'social.article.most-liked', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $page = 1;
        $articles = $this->mostLikedArticles->get($page, 10);

        return new JsonResponse(new MostLikedArticlesView($articles, $page));
    }
}
