<?php

namespace App\Models;

use App\Models\Interfaces\IDocument;
use App\Models\Interfaces\ISection;

class Document implements IDocument
{
    private ?int $id;
    private string $titre;
    private ?string $description;
    private string $statut;
    private int $userId;
    private array $sections = [];
    private ?string $createdAt;
    private ?string $updatedAt;

    public function __construct(
        string $titre,
        int $userId,
        ?string $description = null,
        string $statut = 'brouillon'
    ) {
        $this->titre = $titre;
        $this->userId = $userId;
        $this->description = $description;
        $this->statut = $statut;
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getTitre(): string { return $this->titre; }
    public function getDescription(): ?string { return $this->description; }
    public function getStatut(): string { return $this->statut; }
    public function getUserId(): int { return $this->userId; }
    public function getSections(): array { return $this->sections; }
    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function getUpdatedAt(): ?string { return $this->updatedAt; }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    public function setTitre(string $titre): void { $this->titre = $titre; }
    public function setDescription(?string $description): void { $this->description = $description; }
    public function setStatut(string $statut): void { $this->statut = $statut; }
    public function setCreatedAt(string $createdAt): void { $this->createdAt = $createdAt; }
    public function setUpdatedAt(string $updatedAt): void { $this->updatedAt = $updatedAt; }

    // Gestion des sections (Pattern Composite)
    public function addSection(ISection $section): void
    {
        $this->sections[] = $section;
    }

    public function removeSection(int $sectionId): void
    {
        $this->sections = array_filter($this->sections, function($section) use ($sectionId) {
            return $section->getId() !== $sectionId;
        });
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'description' => $this->description,
            'statut' => $this->statut,
            'user_id' => $this->userId,
            'sections' => array_map(fn($section) => $section->toArray(), $this->sections),
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
}