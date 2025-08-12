<?php

namespace App\Repositories;

use PDO;

class VersionRepository
{
    public function __construct(private PDO $pdo) {}

    public function create(array $data): int
    {
        // Adapte les colonnes/SQL à ton schéma réel
        $sql = "INSERT INTO versions (message, created_at) VALUES (:message, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':message' => $data['message'] ?? '',
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM versions ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM versions WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function restore(int $versionId): bool
    {
        // TODO: implémentation réelle de restauration
        return true;
    }
}