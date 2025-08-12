<?php

namespace App\Services;

use App\Interfaces\IHistorisable;

class NullHistoryManager implements IHistorisable
{
    public function getHistory(): array
    {
        return [];
    }

    public function addToHistory(string $action, array $data): void
    {
        // no-op
    }

    public function getActionByUser(int $userId): array
    {
        return [];
    }

    public function getActionByDate(string $date): array
    {
        return [];
    }
}