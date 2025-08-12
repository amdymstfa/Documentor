<?php

namespace App\Repositories;

use PDO;

class SectionRepository
{
    public function __construct(private PDO $pdo) {}

    private ?array $columnsCache = null; // ['col' => true]
    private ?array $columnMeta   = null; // ['col' => ['Null' => 'NO'|'YES', 'Default' => ...]]
    private ?int $defaultTypeId  = null;

    private function loadColumns(): void
    {
        if ($this->columnsCache !== null && $this->columnMeta !== null) return;

        $this->columnsCache = [];
        $this->columnMeta = [];

        $stmt = $this->pdo->query("DESCRIBE sections");
        $cols = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        foreach ($cols as $c) {
            if (!isset($c['Field'])) continue;
            $field = $c['Field'];
            $this->columnsCache[$field] = true;
            $this->columnMeta[$field] = [
                'Null'    => $c['Null'] ?? 'YES',
                'Default' => $c['Default'] ?? null,
            ];
        }
    }

    private function hasColumn(string $column): bool
    {
        $this->loadColumns();
        return isset($this->columnsCache[$column]);
    }

    private function orderByClause(): string
    {
        return $this->hasColumn('ordre') ? 'ordre ASC, id ASC' : 'id ASC';
    }

    private function getDefaultTypeId(): ?int
    {
        if ($this->defaultTypeId !== null) return $this->defaultTypeId;

        // Essaie table "type_sections"
        try {
            $stmt = $this->pdo->query("SELECT id FROM type_sections ORDER BY id ASC LIMIT 1");
            $id = $stmt->fetchColumn();
            if ($id) {
                $this->defaultTypeId = (int)$id;
                return $this->defaultTypeId;
            }
        } catch (\Throwable $e) {}

        // Essaie table "type_section"
        try {
            $stmt = $this->pdo->query("SELECT id FROM type_section ORDER BY id ASC LIMIT 1");
            $id = $stmt->fetchColumn();
            if ($id) {
                $this->defaultTypeId = (int)$id;
                return $this->defaultTypeId;
            }
        } catch (\Throwable $e) {}

        // Dernier recours
        $this->defaultTypeId = 1;
        return $this->defaultTypeId;
    }

    // Retourne l'ID de la section créée
    public function create(array $data): int
    {
        // Colonnes candidates (incluses uniquement si présentes dans la table)
        $candidates = ['document_id', 'titre', 'contenu', 'parent_id', 'ordre', 'type_id', 'statut_id'];

        $fields = [];
        $params = [];

        foreach ($candidates as $col) {
            if (!$this->hasColumn($col)) continue;

            $value = $data[$col] ?? null;

            // Valeurs par défaut raisonnables si non fournies
            if ($col === 'ordre' && $value === null) {
                $value = 1;
            }

            if ($col === 'type_id' && $value === null) {
                // Si type_id est NOT NULL et sans default, on force un type par défaut
                $value = $this->getDefaultTypeId();
            }

            if ($col === 'statut_id' && $value === null) {
                $value = 1; // Brouillon si existant
            }

            $fields[] = $col;
            $params[":{$col}"] = $value;
        }

        if (empty($fields)) {
            throw new \RuntimeException("Aucune colonne compatible trouvée pour l'insertion dans 'sections'.");
        }

        $columnsSql = implode(', ', $fields);
        $paramsSql  = implode(', ', array_map(fn($f) => ':' . $f, $fields));

        $sql = "INSERT INTO sections ($columnsSql) VALUES ($paramsSql)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return (int)$this->pdo->lastInsertId();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM sections WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function findByDocument(int $documentId): array
    {
        $orderBy = $this->orderByClause();
        $stmt = $this->pdo->prepare("SELECT * FROM sections WHERE document_id = :document_id ORDER BY {$orderBy}");
        $stmt->execute([':document_id' => $documentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function update(int $id, array $data): bool
    {
        $possible = ['titre', 'contenu', 'parent_id', 'ordre', 'type_id', 'statut_id'];

        $fields = [];
        $params = [':id' => $id];

        foreach ($possible as $col) {
            if ($this->hasColumn($col) && array_key_exists($col, $data)) {
                $fields[] = "{$col} = :{$col}";
                $params[":{$col}"] = $data[$col];
            }
        }

        if (empty($fields)) {
            return true;
        }

        $sql = "UPDATE sections SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM sections WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getDocumentIdBySection(int $sectionId): int
    {
        $stmt = $this->pdo->prepare("SELECT document_id FROM sections WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $sectionId]);
        $val = $stmt->fetchColumn();
        return $val ? (int)$val : 0;
    }

    public function findByDocumentId(int $documentId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM sections 
            WHERE document_id = :document_id 
            ORDER BY ordre ASC, id ASC
        ");
        $stmt->execute([':document_id' => $documentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}