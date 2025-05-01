<?php

declare(strict_types=1);

namespace App\Social\Domain\Model;

final class User
{
    public function __construct(
        private readonly int $id,
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }
}
