<?php

declare(strict_types=1);

namespace App\Editorial\Presentation\ViewModel;

use App\Editorial\Domain\Model\User;

class ArticleWithLikeView
{
    public function __construct(
        private readonly ?int $id,
        private string $title,
        private string $content,
        private readonly User $user,
        private ?\DateTimeImmutable $releaseDate,
        private string $status,
        private int $likeCount,
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

    public function status(): string
    {
        return $this->status;
    }

    public function likeCount(): int
    {
        return $this->likeCount;
    }
}
