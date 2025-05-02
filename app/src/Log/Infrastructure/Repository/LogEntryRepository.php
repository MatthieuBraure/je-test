<?php

declare(strict_types=1);

namespace App\Log\Infrastructure\Repository;

use App\Log\Domain\Model\LogEntry;
use App\Log\Domain\Repository\LogEntryRepository as LogEntryRepositoryInterface;
use Doctrine\DBAL\Connection;

class LogEntryRepository implements LogEntryRepositoryInterface
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function save(LogEntry $logEntry): void
    {
        $this->connection->insert(
            'log_entry',
            [
                'entityClass' => $logEntry->entityClass(),
                'entityId' => $logEntry->entityId(),
                'action' => $logEntry->action(),
                'userId' => $logEntry->userId(),
                'data' => $logEntry->data(),
                'loggedAt' => $logEntry->loggedAt()->format(DATE_ATOM),
            ],
        );
    }
}
