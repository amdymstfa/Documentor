<?php

namespace App\Services;

use App\Interfaces\ISection;

/**
 * Implémentation complète de ISection pour les données de section
 */
class Section implements ISection
{
    private array $data;
    private array $children = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getId(): int
    {
        return (int)($this->data['id'] ?? 0);
    }

    public function getTitre(): string
    {
        return (string)($this->data['titre'] ?? '');
    }

    public function getContent(): string
    {
        // Pas de champ contenu dans votre table, retourner chaîne vide
        return '';
    }

    // ✅ AJOUT : Méthode getContenu() manquante (version française de getContent)
    public function getContenu(): string
    {
        return '';
    }

    public function getParentId(): ?int
    {
        return $this->data['parent_id'] ? (int)$this->data['parent_id'] : null;
    }

    public function getOrdre(): int
    {
        return (int)($this->data['ordre'] ?? 0);
    }

    public function getTypeId(): int
    {
        return (int)($this->data['type_id'] ?? 1);
    }

    public function getDocumentId(): int
    {
        return (int)($this->data['document_id'] ?? 0);
    }

    // ✅ AJOUT : Autres méthodes potentiellement manquantes
    public function getParentSectionId(): ?int
    {
        return $this->getParentId();
    }

    public function addChild(ISection $child): void
    {
        $this->children[] = $child;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function removeChildren(int $childId): bool
    {
        $initialCount = count($this->children);
        
        $this->children = array_filter($this->children, function(ISection $child) use ($childId) {
            return $child->getId() !== $childId;
        });
        
        // Retourner true si un enfant a été supprimé
        return count($this->children) < $initialCount;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}