<?php

namespace App\Repositories ;

interface SectionRepository
{
    public function findByDocument(int $documentId): array;
    public function findById(int $id): ?array;
    public function create(array $data): int;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function updateOrder(array $sections): bool;
    public function getDocumentId(int $sectionId): ?int;
}

