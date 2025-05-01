<?php

declare(strict_types=1);

namespace App\Social\Domain\Model;

final class Article
{
    private function __construct(
        private readonly int $id,
        private readonly User $user,
        private bool $isPublished,
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public static function create(
        int $id,
        User $user,
        bool $isPublished,
    ): self {
        return new self(
            id: $id,
            user: $user,
            isPublished: $isPublished,
        );
    }
}
