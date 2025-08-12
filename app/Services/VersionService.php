<?php

namespace App\Services;

use App\Interfaces\IVersionable;
use App\Repositories\VersionRepository;

class VersionService implements IVersionable
{
    public function __construct(private VersionRepository $versions) {}

    public function createVersion(string $comment): int
    {
        return $this->versions->create([
            'message' => $comment,
        ]);
    }

    // L'interface ne prend aucun paramètre
    public function getVersions(): array
    {
        return $this->versions->findAll();
    }

    public function getVersion(int $versionNumber): ?array
    {
        return $this->versions->findById($versionNumber);
    }

    public function restoreVersion(int $versionNumber): bool
    {
        // À adapter selon ton métier
        return $this->versions->restore($versionNumber);
    }

    public function compareVersion(int $version1, int $version2): bool
    {
        $v1 = $this->versions->findById($version1);
        $v2 = $this->versions->findById($version2);

        if (!$v1 || !$v2) return false;

        // Comparaison naïve: structure JSON
        return json_encode($v1) === json_encode($v2);
    }
}