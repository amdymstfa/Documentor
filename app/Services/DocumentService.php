<?php

namespace App\Services;

use App\Interfaces\IDocument;
use App\Interfaces\ISection;

class Document implements IDocument
{
    private int $id;
    private string $titre;
    private string $statut;
    private array $sections;
    private int $redacteurId;

    public function __construct(array $data, array $sectionsData)
    {
        $this->id = (int)$data['id'];
        $this->titre = (string)$data['titre'];
        $this->statut = $data['statut_nom'] ?? 'Brouillon';
        // Sécurise si la colonne n'existe pas ou la clé est absente
        $this->redacteurId = isset($data['redacteur_id']) ? (int)$data['redacteur_id'] : 0;
        $this->sections = $this->buildSections($sectionsData);
    }

    public function getId(): int { return $this->id; }
    public function getTitre(): string { return $this->titre; }
    public function getStatut(): string { return $this->statut; }
    public function getSections(): array { return $this->sections; }
    public function getRedacteurId(): int { return $this->redacteurId; }

    public function addSection(ISection $section): void
    {
        $this->sections[] = $section;
    }

    public function removeSection(int $sectionId): void
    {
        $this->sections = array_filter($this->sections, fn($s) => $s->getId() !== $sectionId);
    }

    public function canBeEditedBy(int $userId): bool
    {
        return $this->redacteurId === $userId && $this->statut === 'Brouillon';
    }

    private function buildSections(array $sectionsData): array
    {
        $sections = [];
        foreach ($sectionsData as $sectionData) {
            $sections[] = new Section($sectionData);
        }
        return $sections;
    }
}