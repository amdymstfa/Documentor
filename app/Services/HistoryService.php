<?php

namespace App\Services;

use App\Interfaces\IHistorisable;

class NullHistoryManager implements IHistorisable
{
    public function addToHistory(string $event, array $data = []): bool
    {
        return true; 
    }
}