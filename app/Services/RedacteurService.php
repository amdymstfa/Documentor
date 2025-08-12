<?php

namespace App\Services;

use App\Interfaces\IRedacteur;
use App\Interfaces\IDocument;
use App\Interfaces\ISection;
use App\Interfaces\IVersionable;
use App\Interfaces\IHistorisable;
use App\Interfaces\IPermissionManager;
use App\Repositories\DocumentRepository;
use App\Repositories\SectionRepository;

class RedacteurService implements IRedacteur
{
    
    private DocumentRepository $documentRepository;
    private SectionRepository $sectionRepository;
    private IVersionable $versionManager;
    private IHistorisable $historyManager;
    private IPermissionManager $permissionManager;
    private int $currentUserId;

    public function __construct(
        DocumentRepository $documentRepository,
        SectionRepository $sectionRepository,
        IVersionable $versionManager,
        IHistorisable $historyManager,
        IPermissionManager $permissionManager,
        int $currentUserId
    ) {
        $this->documentRepository = $documentRepository;
        $this->sectionRepository = $sectionRepository;
        $this->versionManager = $versionManager;
        $this->historyManager = $historyManager;
        $this->permissionManager = $permissionManager;
        $this->currentUserId = $currentUserId;
    }

    /**
     * Crée un nouveau document
     */
 public function createDocument(string $titre, string $template): IDocument
{
    $this->validateTitle($titre);
    $this->validateTemplate($template);

    if (!$this->canCreateDocument()) {
        throw new \Exception("Permissions insuffisantes pour créer un document");
    }

    try {
        // ✅ CORRECTION : Utiliser auteur_id selon votre schéma
        $documentData = [
            'titre'     => $titre,
            'template'  => $template,
            'auteur_id' => $this->currentUserId,  // ✅ Changé de redacteur_id vers auteur_id
            'statut_id' => 1, // Brouillon
        ];
        
        error_log("DEBUG - Document data: " . print_r($documentData, true));
        error_log("DEBUG - Current user ID: " . $this->currentUserId);
        
        $documentId = $this->documentRepository->create($documentData);

        // Créer les sections par défaut
        $this->createDefaultSections($documentId, $template);

        // Historique et versions
        $this->versionManager->createVersion("Création du document");
        $this->historyManager->addToHistory('document_created', [
            'document_id' => $documentId,
            'titre'       => $titre,
            'template'    => $template,
        ]);

        return $this->createDocumentObject($documentId);
    } catch (\Exception $e) {
        error_log("DEBUG - Exception in createDocument: " . $e->getMessage());
        throw new \Exception("Erreur lors de la création : " . $e->getMessage());
    }
}

    /**
     * Met à jour un document
     */
    public function updateDocument(IDocument $document): bool
    {
        // VÉRIFICATION PERMISSIONS
        if (!$this->canEdit($document->getId())) {
            return false;
        }

        try {
            // DÉLÉGATION vers repository
            $success = $this->documentRepository->update($document->getId(), [
                'titre' => $document->getTitre(),
            ]);

            if ($success) {
                // GESTION VERSIONS ET HISTORIQUE
                $this->versionManager->createVersion("Modification du document");
                $this->historyManager->addToHistory('document_updated', [
                    'document_id' => $document->getId(),
                ]);
            }

            return $success;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Supprime un document
     */
    public function deleteDocument(int $documentId): bool
    {
        if (!$this->canEdit($documentId)) {
            return false;
        }

        try {
            $success = $this->documentRepository->delete($documentId);

            if ($success) {
                $this->historyManager->addToHistory('document_deleted', [
                    'document_id' => $documentId,
                ]);
            }

            return $success;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Ajoute une section
     */
    public function addSection(int $documentId, ISection $section): bool
    {
        if (!$this->canEdit($documentId)) {
            return false;
        }

        try {
            $sectionId = $this->sectionRepository->create([
                'document_id' => $documentId,
                'titre'       => $section->getTitre(),
                'contenu'     => $section->getContenu(),
                'parent_id'   => $section->getParentId(),
                'ordre'       => $section->getOrdre(),
            ]);

            // VERSIONS ET HISTORIQUE
            $this->versionManager->createVersion("Ajout section : " . $section->getTitre());
            $this->historyManager->addToHistory('section_added', [
                'document_id' => $documentId,
                'section_id'  => $sectionId,
                'titre'       => $section->getTitre(),
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateSection(ISection $section): bool
    {
        // Récupérer le document lié à la section
        $documentId = method_exists($section, 'getDocumentId')
            ? $section->getDocumentId()
            : $this->sectionRepository->getDocumentIdBySection($section->getId());

        if (!$this->canEdit($documentId)) {
            return false;
        }

        try {
            $success = $this->sectionRepository->update($section->getId(), [
                'titre'     => $section->getTitre(),
                'contenu'   => $section->getContenu(),
                'parent_id' => $section->getParentId(),
                'ordre'     => $section->getOrdre(),
            ]);

            if ($success) {
                $this->versionManager->createVersion("Modification de la section");
                $this->historyManager->addToHistory('section_updated', [
                    'document_id' => $documentId,
                    'section_id'  => $section->getId(),
                ]);
            }

            return $success;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteSection(int $sectionId): bool
    {
        $documentId = $this->sectionRepository->getDocumentIdBySection($sectionId);

        if (!$this->canEdit($documentId)) {
            return false;
        }

        try {
            $success = $this->sectionRepository->delete($sectionId);

            if ($success) {
                $this->historyManager->addToHistory('section_deleted', [
                    'document_id' => $documentId,
                    'section_id'  => $sectionId,
                ]);
            }

            return $success;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Soumet pour validation
     */
    public function submitForValidation(int $documentId): bool
    {
        if (!$this->canEdit($documentId)) {
            return false;
        }

        try {
            // CHANGEMENT DE STATUT
            $success = $this->documentRepository->update($documentId, [
                'statut_id' => 2,
            ]);

            if ($success) {
                $this->versionManager->createVersion("Soumission pour validation");
                $this->historyManager->addToHistory('document_submitted', [
                    'document_id' => $documentId,
                ]);
                $this->notifyValidators($documentId);
            }

            return $success;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Vérifie les permissions d'édition
     */
    public function canEdit(int $documentId): bool
    {
        return $this->permissionManager->hasPermission(
            $this->currentUserId,
            'edit_document',
            $documentId
        );
    }

    /**
     * Vérifie si l'utilisateur peut créer un document
     */
    private function canCreateDocument(): bool
    {
        return $this->permissionManager->hasPermission(
            $this->currentUserId,
            'create_document',
            0
        );
    }

    private function validateTitle(string $titre): void
    {
        if (empty(trim($titre))) {
            throw new \InvalidArgumentException("Le titre ne peut pas être vide");
        }
    }

    private function validateTemplate(string $template): void
    {
        $validTemplates = ['standard', 'site-web', 'application-mobile'];
        if (!in_array($template, $validTemplates, true)) {
            throw new \InvalidArgumentException("Template invalide");
        }
    }

    /**
     * Crée les sections par défaut selon le template
     */
    private function createDefaultSections(int $documentId, string $template): void
    {
        $templates = [
            'standard' => [
                'Présentation du projet',
                'Objectifs',
                'Spécifications fonctionnelles',
                'Spécifications techniques',
            ],
        ];

        $sections = $templates[$template] ?? $templates['standard'];

        foreach ($sections as $index => $titre) {
            $this->sectionRepository->create([
                'document_id' => $documentId,
                'titre'       => $titre,
                'ordre'       => $index + 1,
                'parent_id'   => null,
            ]);
        }
    }

    /**
     * Crée l'objet métier Document à partir des données
     */
    private function createDocumentObject(int $documentId): IDocument
    {
        $data = $this->documentRepository->findById($documentId) ?? [];

        // On ne pousse pas les sections ici: il faudrait des instances ISection.
        // On fournit un Document conforme à IDocument avec les métadonnées.
        return new Document($data);
    }

    /**
     * Notifie les validateurs qu'un document est prêt
     */
    private function service(): \App\Services\RedacteurService
{
    $user = requireAuthenticatedUser();
    $currentUserId = $user ? (int)$user['id'] : 0;

    if ($currentUserId === 0) {
        throw new \Exception("Utilisateur non authentifié");
    }

    return new \App\Services\RedacteurService(
        $this->documentRepository,
        $this->sectionRepository,
        $this->versionManager,
        $this->historyManager,
        $this->permissionManager,
        $currentUserId
    );
}

public function updateDocumentData(int $documentId, array $data): bool
{
    try {
        // Mise à jour simple du titre
        $stmt = $this->documents->getPdo()->prepare("
            UPDATE documents 
            SET titre = :titre 
            WHERE id = :id AND auteur_id = :user_id
        ");
        
        return $stmt->execute([
            ':titre' => $data['titre'],
            ':id' => $documentId,
            ':user_id' => $this->currentUserId
        ]);
        
    } catch (\Exception $e) {
        error_log("Erreur updateDocumentData: " . $e->getMessage());
        return false;
    }
}

public function canModifyDocument(int $documentId): bool
{
    try {
        $stmt = $this->documents->getPdo()->prepare("
            SELECT statut_id, auteur_id 
            FROM documents 
            WHERE id = :id
        ");
        $stmt->execute([':id' => $documentId]);
        $doc = $stmt->fetch();
        
        if (!$doc) {
            return false;
        }
        
        // Vérifier que l'utilisateur est l'auteur
        if ($doc['auteur_id'] != $this->currentUserId) {
            return false;
        }
        
        // Vérifier que le document n'est pas déjà soumis/validé
        $stmt = $this->documents->getPdo()->prepare("
            SELECT nom FROM statuts WHERE id = :statut_id
        ");
        $stmt->execute([':statut_id' => $doc['statut_id']]);
        $statut = $stmt->fetch();
        
        // Seuls les documents en "Brouillon" peuvent être modifiés
        return $statut && in_array($statut['nom'], ['Brouillon', 'Rejeté']);
        
    } catch (\Exception $e) {
        error_log("Erreur canModifyDocument: " . $e->getMessage());
        return false;
    }
}

public function submitDocument(int $documentId): bool
{
    try {
        if (!$this->canModifyDocument($documentId)) {
            return false;
        }
        
        $pdo = $this->documents->getPdo();
        $pdo->beginTransaction();
        
        // Mettre à jour le statut
        $stmt = $pdo->prepare("
            UPDATE documents 
            SET statut_id = (SELECT id FROM statuts WHERE nom = 'Soumis'),
                date_soumission = NOW()
            WHERE id = :id AND auteur_id = :user_id
        ");
        
        $result = $stmt->execute([
            ':id' => $documentId,
            ':user_id' => $this->currentUserId
        ]);
        
        if ($result && $stmt->rowCount() > 0) {
            $pdo->commit();
            return true;
        } else {
            $pdo->rollBack();
            return false;
        }
        
    } catch (\Exception $e) {
        if (isset($pdo)) {
            $pdo->rollBack();
        }
        error_log("Erreur submitDocument: " . $e->getMessage());
        return false;
    }
}
}