<?php

declare(strict_types=1);

namespace App\Consulting\Presentation\Http;

use App\Consulting\Domain\Finder\ArticleFinder;
use App\Consulting\Domain\Model\Article;
use App\Consulting\Presentation\Factory\ArticleWithSocialViewFactory;
use App\Core\Domain\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListArticlesController extends AbstractController
{
    public function __construct(
        private readonly ArticleFinder $articleFinder,
        private readonly ArticleWithSocialViewFactory $articleWithSocialViewFactory,
    ) {
    }

    #[Route('/', name: 'consulting.list.articles')]
    public function __invoke(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();
        $articles = $this->articleFinder->findAll();

        $articlesWithSocial = array_map(fn (Article $article) => $this->articleWithSocialViewFactory->create($article, $userId), $articles);

        return $this->render('consulting/list-articles.html.twig', ['articles' => $articlesWithSocial]);
    }
}
