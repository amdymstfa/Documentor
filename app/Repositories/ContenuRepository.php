<?php

namespace App\Repositories ;


interface ContenuRepository
{
    public function findBySection(int $sectionId): ?array;
    public function createOrUpdate(int $sectionId, string $texte): bool;
    public function deleteBySection(int $sectionId): bool;
}
