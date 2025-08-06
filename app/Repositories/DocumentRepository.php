<?php

namespace App\Repositories ;

interface DocumentRepository
{
    public function findById(int $id): ?array;
    public function findByRedacteur(int $redacteurId): array;
    public function findByRedacteurWithDetails(int $redacteurId): array;
    public function create(array $data): int;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function updateTimestamp(int $id): void;
    public function search(int $redacteurId, string $query): array;
    public function belongsToRedacteur(int $documentId, int $redacteurId): bool;
}