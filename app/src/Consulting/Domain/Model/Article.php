<?php

declare(strict_types=1);

namespace App\Consulting\Domain\Model;

final class Article
{
    public function __construct(
        private readonly int $id,
        private readonly string $title,
        private readonly string $content,
        private readonly User $user,
        private readonly int $likeCount,
        private readonly bool $hasLiked,
        private readonly bool $canLike,
        private readonly ?\DateTimeImmutable $releaseDate,
    ) {
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function releaseDate(): ?\DateTimeImmutable
    {
        return $this->releaseDate;
    }

    public function likeCount(): int
    {
        return $this->likeCount;
    }

    public function hasLiked(): bool
    {
        return $this->hasLiked;
    }

    public function canLike(): bool
    {
        return $this->canLike;
    }
}
