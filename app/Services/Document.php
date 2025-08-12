<?php

namespace App\Services;

use App\Interfaces\IDocument;
use App\Interfaces\ISection;

class Document implements IDocument
{
    private int $id = 0;
    private string $titre = '';
    private string $status = 'brouillon'; // valeur par défaut
    private int $redacteurId = 0;

    /** @var ISection[] */
    private array $sections = [];

    /**
     * Constructeur résilient vis-à-vis des schémas hétérogènes.
     */
    public function __construct(array $data = [], array $sections = [])
    {
        $this->fillFromArray($data);

        // On n'ajoute que des ISection réelles si fournies (sinon, laisser vide).
        foreach ($sections as $section) {
            if ($section instanceof ISection) {
                $this->sections[] = $section;
            }
        }
    }

    private function fillFromArray(array $data): void
    {
        if (isset($data['id'])) {
            $this->id = (int) $data['id'];
        }

        if (isset($data['titre'])) {
            $this->titre = (string) $data['titre'];
        }

        // status: accepte 'statut' (string) ou mappe 'statut_id' -> string
        if (isset($data['statut']) && $data['statut'] !== null && $data['statut'] !== '') {
            $this->status = (string) $data['statut'];
        } elseif (isset($data['status']) && $data['status'] !== null && $data['status'] !== '') {
            $this->status = (string) $data['status'];
        } elseif (isset($data['statut_id'])) {
            $sid = (int) $data['statut_id'];
            $this->status = match ($sid) {
                2 => 'soumis',
                3 => 'validé',
                default => 'brouillon',
            };
        }

        // auteur/redacteur
        if (isset($data['redacteur_id'])) {
            $this->redacteurId = (int) $data['redacteur_id'];
        } elseif (isset($data['auteur_id'])) {
            $this->redacteurId = (int) $data['auteur_id'];
        }
    }

    // IDocument

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function addSection(ISection $section): void
    {
        $this->sections[] = $section;
    }

    public function getSection(): array
    {
        return $this->sections;
    }

    public function removeSection(int $sectionId): bool
    {
        foreach ($this->sections as $i => $section) {
            if (method_exists($section, 'getId') && $section->getId() === $sectionId) {
                array_splice($this->sections, $i, 1);
                return true;
            }
        }
        return false;
    }

    public function getRedacteurId(): int
    {
        return $this->redacteurId;
    }

    public function canEditBy(int $user): bool
    {
        // règle simple: le rédacteur/auteur peut éditer
        return $user === $this->redacteurId || $this->redacteurId === 0;
    }
}