<?php

namespace App\Services;

use App\Interfaces\IPermissionManager;

class AllowAllPermissionManager implements IPermissionManager
{
    public function hasPermission(int $userId, string $permission, int $resourceId): bool
    {
        // Autorise tout pour les tests Postman
        return true;
    }

    public function grantPermission(int $userId, string $permission, int $resourceId): void
    {
        // no-op
    }

    public function revokePermission(int $userId, string $permission, int $resourceId): void
    {
        // no-op
    }

    public function getUserPermissions(int $userId): array
    {
        // Autorisations fictives (tu peux retourner [] si tu préfères)
        return ['*'];
    }
}