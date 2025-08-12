<?php

namespace App\Repositories;

use PDO;
use PDOException;

class DocumentRepository
{
    public function __construct(private PDO $pdo) {}

    private ?array $columnsCache = null;

    private function loadColumns(): void
    {
        if ($this->columnsCache !== null) return;

        $this->columnsCache = [];
        $stmt = $this->pdo->query("DESCRIBE documents");
        $cols = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        foreach ($cols as $c) {
            if (isset($c['Field'])) {
                $this->columnsCache[$c['Field']] = true;
            }
        }
    }

    private function hasColumn(string $column): bool
    {
        $this->loadColumns();
        return isset($this->columnsCache[$column]);
    }

    public function create(array $data): int
    {
        // ✅ CORRECTION : Utiliser auteur_id selon votre schéma
        $candidates = ['titre', 'auteur_id', 'statut_id', 'template'];

        $fields = [];
        $params = [];

        foreach ($candidates as $col) {
            if (!$this->hasColumn($col)) continue;

            $value = $data[$col] ?? null;

            // Valeur par défaut pour statut_id
            if ($col === 'statut_id' && $value === null) {
                $value = 1; // Brouillon
            }

            // ✅ Mapper redacteur_id vers auteur_id si nécessaire
            if ($col === 'auteur_id' && $value === null && isset($data['redacteur_id'])) {
                $value = $data['redacteur_id'];
            }

            $fields[] = $col;
            $params[":{$col}"] = $value;
        }

        if (empty($fields)) {
            throw new PDOException("La table documents ne contient aucune des colonnes attendues.");
        }

        $columnsSql = implode(', ', $fields);
        $paramsSql  = implode(', ', array_map(fn($f) => ':' . $f, $fields));

        $sql = "INSERT INTO documents ($columnsSql) VALUES ($paramsSql)";
        
        // ✅ DEBUG temporaire
        error_log("DEBUG SQL: " . $sql);
        error_log("DEBUG PARAMS: " . print_r($params, true));
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return (int)$this->pdo->lastInsertId();
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT d.*, s.nom AS statut_nom
                FROM documents d
                LEFT JOIN statuts s ON s.id = d.statut_id
                WHERE d.id = :id
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        // ✅ Mapper auteur_id vers redacteur_id pour compatibilité
        $row['redacteur_id'] = $row['auteur_id'];

        return $row;
    }

    public function update(int $id, array $data): bool
    {
        $possible = ['titre', 'template', 'auteur_id', 'statut_id'];

        $fields = [];
        $params = [':id' => $id];

        foreach ($possible as $col) {
            if ($this->hasColumn($col) && array_key_exists($col, $data)) {
                $fields[] = "{$col} = :{$col}";
                $params[":{$col}"] = $data[$col];
            }
        }

        // ✅ Mapper redacteur_id vers auteur_id
        if (array_key_exists('redacteur_id', $data) && $this->hasColumn('auteur_id')) {
            $fields[] = "auteur_id = :auteur_id";
            $params[":auteur_id"] = $data['redacteur_id'];
        }

        if (empty($fields)) {
            return true;
        }

        $sql = "UPDATE documents SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM documents WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}