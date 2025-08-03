<?php

namespace App\Services;

use App\Models\Interfaces\IRedacteur;
use App\Models\Interfaces\IDocument;
use App\Models\Interfaces\ISection;
use App\Models\Document;
use App\Models\Section;
use App\Repositories\Interfaces\IDocumentRepository;
use App\Repositories\Interfaces\ISectionRepository;

class RedacteurService implements IRedacteur
{
    private IDocumentRepository $documentRepository;
    private ISectionRepository $sectionRepository;

    public function __construct(
        IDocumentRepository $documentRepository,
        ISectionRepository $sectionRepository
    ) {
        $this->documentRepository = $documentRepository;
        $this->sectionRepository = $sectionRepository;
    }

    public function creerDocument(array $data): IDocument
    {
        $document = new Document(
            $data['titre'],
            $data['user_id'],
            $data['description'] ?? null,
            'brouillon'
        );

        return $this->documentRepository->save($document);
    }

    public function modifierDocument(int $documentId, array $data): IDocument
    {
        $document = $this->documentRepository->findById($documentId);
        if (!$document) {
            throw new \Exception("Document non trouvé");
        }

        if (isset($data['titre'])) {
            $document->setTitre($data['titre']);
        }
        if (isset($data['description'])) {
            $document->setDescription($data['description']);
        }

        return $this->documentRepository->save($document);
    }

    public function supprimerDocument(int $documentId): bool
    {
        return $this->documentRepository->delete($documentId);
    }

    public function ajouterSection(int $documentId, array $sectionData): ISection
    {
        $section = new Section(
            $sectionData['titre'],
            $documentId,
            $sectionData['ordre'],
            $sectionData['type_section'] ?? 'standard',
            $sectionData['parent_id'] ?? null,
            $sectionData['contenu'] ?? null
        );

        return $this->sectionRepository->save($section);
    }

    public function modifierSection(int $sectionId, array $data): ISection
    {
        $section = $this->sectionRepository->findById($sectionId);
        if (!$section) {
            throw new \Exception("Section non trouvée");
        }

        if (isset($data['titre'])) {
            $section->setTitre($data['titre']);
        }
        if (isset($data['contenu'])) {
            $section->setContenu($data['contenu']);
        }
        if (isset($data['ordre'])) {
            $section->setOrdre($data['ordre']);
        }

        return $this->sectionRepository->save($section);
    }

    public function supprimerSection(int $sectionId): bool
    {
        return $this->sectionRepository->delete($sectionId);
    }

    public function soumettreValidation(int $documentId): bool
    {
        return $this->documentRepository->updateStatut($documentId, 'en_revision');
    }

    public function getMesDocuments(int $userId): array
    {
        $documents = $this->documentRepository->findByUserId($userId);
        
        // Charger les sections pour chaque document
        foreach ($documents as $document) {
            $sections = $this->sectionRepository->findByDocumentId($document->getId());
            foreach ($sections as $section) {
                $document->addSection($section);
            }
        }

        return $documents;
    }
}