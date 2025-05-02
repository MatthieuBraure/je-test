<?php

declare(strict_types=1);

namespace App\Log\Domain\EventListener;

use App\Core\Application\Event\EventSubscriber;
use App\Log\Domain\Model\LogEntry;
use App\Log\Domain\Repository\LogEntryRepository;
use App\Social\Domain\Event\ArticleLiked as ArticleLikedEvent;
use App\Social\Domain\Model\Article;

class ArticleLiked implements EventSubscriber
{
    public function __construct(private readonly LogEntryRepository $logEntryRepository)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ArticleLikedEvent::class => 'onArticleLiked',
        ];
    }

    public function onArticleLiked(ArticleLikedEvent $event): void
    {
        $logEntry = LogEntry::create(
            entityClass: Article::class,
            entityId: (string) $event->articleId,
            action: 'like',
            userId: $event->userId,
            data: json_encode(['articleId' => $event->articleId, 'userId' => $event->userId]),
        );
        $this->logEntryRepository->save($logEntry);
    }
}
