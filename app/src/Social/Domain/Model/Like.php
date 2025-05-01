<?php

declare(strict_types=1);

namespace App\Social\Domain\Model;

class Like
{
    private function __construct(
        private readonly ?int $id,
        private readonly Article $article,
        private readonly User $user,
        private readonly \DateTimeImmutable $createdAt,
    ) {
    }

    public static function create(Article $article, User $user, ?int $id = null, ?\DateTimeImmutable $createdAt = null): self
    {
        return new self(
            id: $id,
            article: $article,
            user: $user,
            createdAt: $createdAt ?? new \DateTimeImmutable(),
        );
    }

    public function id(): int
    {
        return $this->id;
    }

    public function article(): Article
    {
        return $this->article;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
