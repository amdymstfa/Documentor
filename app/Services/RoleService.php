<?php

namespace App\Services;

use App\Models\Role;

class RoleService {
    private Role $roleModel;

    private array $permissionsMap = [
        'Rédacteur' => ['Écrire', 'Modifier le contenu'],
        'Validateur' => ['Valider', 'Commenter', 'Demander modifications'],
        'Client' => ['Consulter documents', 'Donner son avis'],
        'Générateur' => ['Exporter documents', 'Générer rapports'],
    ];

    private array $redirectMap = [
        'Rédacteur' => '/dashboard/redacteur',
        'Validateur' => '/dashboard/validateur',
        'Client' => '/dashboard/client',
        'Générateur' => '/dashboard/generateur',
    ];

    public function __construct(Role $roleModel) {
        $this->roleModel = $roleModel;
    }

    /**
     * Retourne le chemin de redirection en fonction du rôle
     */
    public function getRedirectPath(int $roleId): string {
        $role = $this->roleModel->findById($roleId);
        if (!$role) {
            throw new \InvalidArgumentException("Rôle non trouvé");
        }
        return $this->redirectMap[$role['nom']] ?? '/dashboard';
    }

    /**
     * Retourne les permissions liées au rôle
     */
    public function getPermissionsForRole(int $roleId): array {
        $role = $this->roleModel->findById($roleId);
        if (!$role) {
            return [];
        }
        return $this->permissionsMap[$role['nom']] ?? [];
    }

    /**
     * Vérifie si le rôle a une permission spécifique
     */
    public function hasPermission(int $roleId, string $permission): bool {
        $permissions = $this->getPermissionsForRole($roleId);
        return in_array($permission, $permissions);
    }

    /**
     * Retourne les informations du rôle enrichies des permissions
     */
    public function getRoleInfo(int $roleId): ?array {
        $role = $this->roleModel->findById($roleId);
        if (!$role) {
            return null;
        }
        $role['permissions'] = $this->getPermissionsForRole($roleId);
        return $role;
    }

    /**
     * Récupère tous les rôles disponibles
     */
    public function getAllRoles(): array {
        return $this->roleModel->findAll();
    }
}