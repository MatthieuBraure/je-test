<?php

declare(strict_types=1);

namespace App\Log\Domain\Repository;

use App\Log\Domain\Model\LogEntry;

interface LogEntryRepository
{
    public function save(LogEntry $logEntry): void;
}
