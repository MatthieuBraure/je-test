<?php

declare(strict_types=1);

namespace App\Log\Domain\EventListener;

use App\Core\Application\Event\EventSubscriber;
use App\Log\Domain\Model\LogEntry;
use App\Log\Domain\Repository\LogEntryRepository;
use App\Social\Domain\Event\ArticleUnliked as ArticleUnlikedEvent;
use App\Social\Domain\Model\Article;

class ArticleUnliked implements EventSubscriber
{
    public function __construct(private readonly LogEntryRepository $logEntryRepository)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ArticleUnlikedEvent::class => 'onArticleUnLiked',
        ];
    }

    public function onArticleUnLiked(ArticleUnlikedEvent $event): void
    {
        $logEntry = LogEntry::create(
            entityClass: Article::class,
            entityId: (string) $event->articleId,
            action: 'unlike',
            userId: $event->userId,
            data: json_encode(['articleId' => $event->articleId, 'userId' => $event->userId]),
        );
        $this->logEntryRepository->save($logEntry);
    }
}
