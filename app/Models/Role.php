<?php
namespace App\Models;

use PDO;

class Role {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Trouve un rôle par son ID
     */
    public function findById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT id, nom, description FROM roles WHERE id = ?");
        $stmt->execute([$id]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $role ?: null;
    }

    /**
     * Récupère tous les rôles
     */
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT id, nom, description FROM roles ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Trouve un rôle par son nom
     */
    public function findByName(string $nom): ?array {
        $stmt = $this->pdo->prepare("SELECT id, nom, description FROM roles WHERE nom = ?");
        $stmt->execute([$nom]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $role ?: null;
    }
}