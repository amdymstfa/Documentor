<?php

namespace App\Models;

use App\Models\Interfaces\ISection;

class Section implements ISection
{
    private ?int $id;
    private string $titre;
    private ?string $contenu;
    private int $ordre;
    private ?int $parentId;
    private int $documentId;
    private string $typeSection;
    private array $children = [];

    public function __construct(
        string $titre,
        int $documentId,
        int $ordre,
        string $typeSection = 'standard',
        ?int $parentId = null,
        ?string $contenu = null
    ) {
        $this->titre = $titre;
        $this->documentId = $documentId;
        $this->ordre = $ordre;
        $this->typeSection = $typeSection;
        $this->parentId = $parentId;
        $this->contenu = $contenu;
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getTitre(): string { return $this->titre; }
    public function getContenu(): ?string { return $this->contenu; }
    public function getOrdre(): int { return $this->ordre; }
    public function getParentId(): ?int { return $this->parentId; }
    public function getDocumentId(): int { return $this->documentId; }
    public function getTypeSection(): string { return $this->typeSection; }
    public function getChildren(): array { return $this->children; }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    public function setTitre(string $titre): void { $this->titre = $titre; }
    public function setContenu(?string $contenu): void { $this->contenu = $contenu; }
    public function setOrdre(int $ordre): void { $this->ordre = $ordre; }
    public function setParentId(?int $parentId): void { $this->parentId = $parentId; }

    // Pattern Composite - Gestion hiérarchique
    public function addChild(ISection $child): void
    {
        $this->children[] = $child;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'contenu' => $this->contenu,
            'ordre' => $this->ordre,
            'parent_id' => $this->parentId,
            'document_id' => $this->documentId,
            'type_section' => $this->typeSection,
            'children' => array_map(fn($child) => $child->toArray(), $this->children)
        ];
    }
}