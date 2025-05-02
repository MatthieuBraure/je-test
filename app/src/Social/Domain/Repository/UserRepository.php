<?php

declare(strict_types=1);

namespace App\Social\Domain\Repository;

use App\Social\Domain\Model\User;

interface UserRepository
{
    public function get(int $userId): User;
}
