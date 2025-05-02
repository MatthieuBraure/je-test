<?php

declare(strict_types=1);

namespace App\Log\Domain\Model;

class LogEntry
{
    private function __construct(
        private string $entityClass,
        private string $entityId,
        private string $action,
        private int $userId,
        private \DateTimeInterface $loggedAt,
        private string $data,
    ) {
    }

    public function entityClass(): string
    {
        return $this->entityClass;
    }

    public function entityId(): string
    {
        return $this->entityId;
    }

    public function action(): string
    {
        return $this->action;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function loggedAt(): \DateTimeInterface
    {
        return $this->loggedAt;
    }

    public function data(): string
    {
        return $this->data;
    }

    public static function create(
        string $entityClass,
        string $entityId,
        string $action,
        int $userId,
        string $data,
    ): self {
        return new self(
            entityClass: $entityClass,
            entityId: $entityId,
            action: $action,
            userId: $userId,
            loggedAt: new \DateTimeImmutable(),
            data: $data,
        );
    }
}
