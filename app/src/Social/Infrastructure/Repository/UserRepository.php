<?php

declare(strict_types=1);

namespace App\Social\Infrastructure\Repository;

use App\Social\Domain\Model\User;
use App\Social\Domain\Repository\UserRepository as UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct()
    {
    }

    public function get(int $userId): User
    {
        return new User($userId);
    }
}
