<?php

declare(strict_types=1);

namespace App\Social\Domain\Policy;

use App\Social\Domain\Model\Article;
use App\Social\Domain\Model\User;

class CanLike
{
    public function canLike(Article $article, User $user): bool
    {
        if (false === $article->isPublished()) {
            return false;
        }

        if ($article->user()->id() === $user->id()) {
            return false;
        }

        return true;
    }
}
