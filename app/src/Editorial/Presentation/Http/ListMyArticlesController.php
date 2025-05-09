<?php

declare(strict_types=1);

namespace App\Editorial\Presentation\Http;

use App\Core\Domain\Model\User;
use App\Editorial\Application\Paginator\Paginator;
use App\Editorial\Application\Query\GetArticles\RetrieveArticles;
use App\Editorial\Domain\Finder\ArticleFinder;
use App\Editorial\Domain\Model\Article;
use App\Editorial\Presentation\Factory\ArticleWithSocialViewFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListMyArticlesController extends AbstractController
{
    public function __construct(
        private readonly ArticleFinder $articleFinder,
        private readonly ArticleWithSocialViewFactory $articleWithSocialViewFactory,
    ) {
    }

    #[Route('/editorial/article/', name: 'editorial.get.my.articles')]
    public function __invoke(Request $request): Response
    {
        $page = 1;
        $itemPerPage = 10;

        /** @var User $user */
        $user = $this->getUser();
        $query = new RetrieveArticles($user->getId(), [], new Paginator($page, $itemPerPage));

        $results = $this->articleFinder->retrieveArticles($query);

        $articlesWithLikes = array_map(
            fn (Article $article) => $this->articleWithSocialViewFactory->create($article),
            $results->items(),
        );

        $pagination = [
            'page' => $page,
            'itemPerPage' => $itemPerPage,
            'totalResult' => $results->totalResult(),
        ];

        return $this->render('editorial/list-my-articles.html.twig', ['articles' => $articlesWithLikes, 'pagination' => $pagination]);
    }
}
