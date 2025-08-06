<?php

namespace App\Interfaces ;


interface IPermissionManager
{
    public function hasPermission(int $userId, string $permission, int $resourceId): bool;
    public function grantPermission(int $userId, string $permission, int $resourceId): void;
    public function revokePermission(int $userId, string $permission, int $resourceId): void;
    public function getUserPermissions(int $userId): array;
}