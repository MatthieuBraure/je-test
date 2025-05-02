<?php

declare(strict_types=1);

namespace App\Editorial\Application\Command\ConvertToDraft;

use App\Core\Application\Command\CommandHandler;
use App\Core\Domain\Event\EventDispatcher as EventDispatcherInterface;
use App\Editorial\Domain\Event\ArticleStatusChangedToDraft;
use App\Editorial\Domain\Repository\ArticleRepository;

class ConvertToDraftHandler implements CommandHandler
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly EventDispatcherInterface $eventDispatcher)
    {
    }

    public function __invoke(ConvertToDraft $command): void
    {
        $article = $this->articleRepository->get($command->articleId());

        $article->convertToDraft($command->releaseDate());

        $this->articleRepository->save($article);
        $this->eventDispatcher->dispatch(new ArticleStatusChangedToDraft($command->articleId()));
    }
}
