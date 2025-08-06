<?php

namespace App\Interfaces ;

interface IRoleManager
{
    public function assignRole(int $userId, string $role): void;
    public function removeRole(int $userId, string $role): void;
    public function getUserRoles(int $userId): array;
    public function getRolePermissions(string $role): array;
}