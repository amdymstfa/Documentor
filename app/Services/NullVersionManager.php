<?php

namespace App\Services;

use App\Interfaces\IVersionable;

class NullVersionManager implements IVersionable
{
    // Respecte exactement la signature: string $comment : int
    public function createVersion(string $comment): int
    {
        // Pas de persistance - on retourne un ID fictif
        return 1;
    }

    // Respecte la signature: aucun argument
    public function getVersions(): array
    {
        return [];
    }

    // Respecte la signature: int $versionNumber : ?array
    public function getVersion(int $versionNumber): ?array
    {
        return null;
    }

    // Respecte la signature: int $versionNumber : bool
    public function restoreVersion(int $versionNumber): bool
    {
        return true;
    }

    // Respecte la signature: int,int : bool
    public function compareVersion(int $version1, int $version2): bool
    {
        // Par défaut: on dit qu'elles diffèrent
        return false;
    }
}