<?php

namespace App\Controllers;

use App\Repositories\DocumentRepository;
use App\Repositories\SectionRepository;
use App\Services\RedacteurService;
use App\Services\Section; 
use App\Interfaces\IVersionable;
use App\Interfaces\IHistorisable;
use App\Interfaces\IPermissionManager;

class DocumentController
{
    public function __construct(
        private DocumentRepository $documents,
        private SectionRepository $sections,
        private IVersionable $versions,
        private IHistorisable $history,
        private IPermissionManager $permissions
    ) {}

    // POST /api/documents
    public function store(): void
    {
        header('Content-Type: application/json');

        try {
            $input = $this->jsonInput();
            
            if (!$this->has($input, ['titre', 'template'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'titre et template sont requis']);
                return;
            }

            $user = requireAuthenticatedUser();
            if (!$user) {
                http_response_code(401);
                echo json_encode(['success' => false, 'error' => 'Utilisateur non authentifié']);
                return;
            }

            $service = $this->service();
            
            $result = $service->createDocument(
                trim((string)$input['titre']),
                trim((string)$input['template'])
            );
            
            // Si createDocument retourne un objet Document
            if (is_object($result)) {
                $documentId = method_exists($result, 'getId') ? $result->getId() : null;
                $documentData = [
                    'id' => $documentId,
                    'titre' => method_exists($result, 'getTitre') ? $result->getTitre() : $input['titre'],
                    'template' => method_exists($result, 'getTemplate') ? $result->getTemplate() : $input['template'],
                    'statut' => method_exists($result, 'getStatut') ? $result->getStatut() : 'Brouillon',
                    'redacteur_id' => (int)$user['id'],
                    'created_at' => method_exists($result, 'getCreatedAt') ? $result->getCreatedAt() : date('Y-m-d H:i:s')
                ];
            }
            // Si createDocument retourne un ID
            else if (is_numeric($result) && $result > 0) {
                $documentId = (int)$result;
                $document = $this->documents->findById($documentId);
                $documentData = [
                    'id' => $documentId,
                    'titre' => $document['titre'] ?? $input['titre'],
                    'template' => $document['template'] ?? $input['template'],
                    'statut' => $document['statut_nom'] ?? 'Brouillon',
                    'redacteur_id' => (int)$user['id'],
                    'created_at' => $document['created_at'] ?? date('Y-m-d H:i:s')
                ];
            }
            // Si createDocument retourne false/null
            else {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'Création de document refusée']);
                return;
            }
            
            http_response_code(201);
            echo json_encode([
                'success' => true, 
                'message' => 'Document créé avec succès',
                'data' => $documentData
            ]);
            
        } catch (\InvalidArgumentException $e) {
            http_response_code(422);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        } catch (\Exception $e) {
            error_log("Erreur création document: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Erreur serveur: ' . $e->getMessage()]);
        }
    }

    // GET /api/documents/{id}
    public function show(int $id): void
    {
        header('Content-Type: application/json');
        
        try {
            $document = $this->documents->findById($id);
            
            if (!$document) {
                http_response_code(404);
                echo json_encode(['success' => false, 'error' => 'Document non trouvé']);
                return;
            }

            // Récupérer les sections
            $sections = $this->sections->findByDocumentId($id);
            
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'data' => [
                    'document' => $document,
                    'sections' => $sections
                ]
            ]);
            
        } catch (\Exception $e) {
            error_log("Erreur show document: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Erreur serveur']);
        }
    }

    // PATCH /api/documents/{id}
    // public function update(int $id): void
    // {
    //     header('Content-Type: application/json');
        
    //     try {
    //         $input = $this->jsonInput();
            
    //         if (!$this->has($input, ['titre'])) {
    //             http_response_code(400);
    //             echo json_encode(['success' => false, 'error' => 'titre est requis']);
    //             return;
    //         }

    //         $document = $this->documents->findById($id);
    //         if (!$document) {
    //             http_response_code(404);
    //             echo json_encode(['success' => false, 'error' => 'Document non trouvé']);
    //             return;
    //         }

    //         $service = $this->service();
    //         $success = $service->updateDocument($id, $input);
            
    //         if (!$success) {
    //             http_response_code(403);
    //             echo json_encode(['success' => false, 'error' => 'Modification de document refusée']);
    //             return;
    //         }

    //         http_response_code(200);
    //         echo json_encode(['success' => true, 'message' => 'Document mis à jour']);
            
    //     } catch (\Exception $e) {
    //         error_log("Erreur update document: " . $e->getMessage());
    //         http_response_code(500);
    //         echo json_encode(['success' => false, 'error' => 'Erreur serveur']);
    //     }
    // }
    public function update(int $id): void
{
    header('Content-Type: application/json');
    
    try {
        $input = $this->jsonInput();
        
        if (!$this->has($input, ['titre'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'titre est requis']);
            return;
        }

        $document = $this->documents->findById($id);
        if (!$document) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Document non trouvé']);
            return;
        }

        // ✅ CORRECTION : Passer les données directement au lieu d'un objet
        $service = $this->service();
        $success = $service->updateDocumentData($id, $input);
        
        if (!$success) {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'Modification de document refusée']);
            return;
        }

        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Document mis à jour']);
        
    } catch (\Exception $e) {
        error_log("Erreur update document: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Erreur serveur']);
    }
}

    // DELETE /api/documents/{id}
    public function destroy(int $id): void
    {
        header('Content-Type: application/json');
        
        try {
            $service = $this->service();
            $success = $service->deleteDocument($id);
            
            if (!$success) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'Suppression de document refusée']);
                return;
            }

            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Document supprimé']);
            
        } catch (\Exception $e) {
            error_log("Erreur delete document: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Erreur serveur']);
        }
    }

    // POST /api/documents/{id}/sections
    public function addSection(int $documentId): void
    {
        header('Content-Type: application/json');
        
        try {
            $input = $this->jsonInput();
            
            if (!$this->has($input, ['titre'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'titre est requis']);
                return;
            }

            // Vérifier que le document existe
            $document = $this->documents->findById($documentId);
            if (!$document) {
                http_response_code(404);
                echo json_encode(['success' => false, 'error' => 'Document non trouvé']);
                return;
            }

            $service = $this->service();
            
            // ✅ CORRECTION : Créer un objet Section qui implémente ISection
            $sectionData = [
                'id' => 0,
                'document_id' => $documentId,
                'titre' => trim((string)$input['titre']),
                'contenu' => $input['contenu'] ?? null,
                'parent_id' => $input['parent_id'] ?? null,
                'ordre' => $input['ordre'] ?? 1,
            ];
            
            $section = new Section($sectionData);
            
            $success = $service->addSection($documentId, $section);
            
            if (!$success) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'Ajout de section refusé']);
                return;
            }

            http_response_code(201);
            echo json_encode(['success' => true, 'message' => 'Section ajoutée avec succès']);
            
        } catch (\InvalidArgumentException $e) {
            http_response_code(422);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        } catch (\Exception $e) {
            error_log("Erreur ajout section: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Erreur serveur: ' . $e->getMessage()]);
        }
    }

    // POST /api/documents/{id}/submit
   public function submit(int $id): void
{
    header('Content-Type: application/json');
    
    try {
        // 1. Vérifier que le document existe et appartient à l'utilisateur
        $document = $this->documents->findById($id);
        if (!$document) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Document non trouvé']);
            return;
        }
        
        // 2. Vérifier les permissions
        $service = $this->service();
        if (!$service->canModifyDocument($id)) {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'Accès refusé']);
            return;
        }
        
        // 3. Validation du document avant soumission
        $validation = $this->validateDocumentForSubmission($id);
        if (!$validation['valid']) {
            http_response_code(400);
            echo json_encode([
                'success' => false, 
                'error' => 'Document incomplet',
                'details' => $validation['errors']
            ]);
            return;
        }
        
        // 4. Commencer une transaction pour assurer la cohérence
        $pdo = $this->documents->getPdo();
        $pdo->beginTransaction();
        
        try {
            // 5. Mettre à jour le statut du document
            $stmt = $pdo->prepare("
                UPDATE documents 
                SET statut_id = (SELECT id FROM statuts WHERE nom = 'Soumis'),
                    date_soumission = NOW(),
                    version = version + 1
                WHERE id = :id
            ");
            $stmt->execute([':id' => $id]);
            
            // 6. Enregistrer toutes les sections modifiées
            $this->saveAllSections($id, $pdo);
            
            // 7. Créer un historique de soumission
            $this->createSubmissionHistory($id, $pdo);
            
            // 8. Valider la transaction
            $pdo->commit();
            
            http_response_code(200);
            echo json_encode([
                'success' => true, 
                'message' => 'Document soumis avec succès',
                'data' => [
                    'document_id' => $id,
                    'new_status' => 'Soumis',
                    'submission_date' => date('Y-m-d H:i:s')
                ]
            ]);
            
        } catch (\Exception $e) {
            // Annuler la transaction en cas d'erreur
            $pdo->rollBack();
            throw $e;
        }
        
    } catch (\Exception $e) {
        error_log("Erreur soumission document $id: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Erreur lors de la soumission']);
    }
}

private function validateDocumentForSubmission(int $documentId): array
{
    $errors = [];
    
    try {
        $pdo = $this->documents->getPdo();
        
        // Vérifier que le document a un titre
        $stmt = $pdo->prepare("SELECT titre FROM documents WHERE id = :id");
        $stmt->execute([':id' => $documentId]);
        $doc = $stmt->fetch();
        
        if (!$doc || empty(trim($doc['titre']))) {
            $errors[] = "Le document doit avoir un titre";
        }
        
        // Vérifier qu'il y a au moins une section
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM sections WHERE document_id = :id");
        $stmt->execute([':id' => $documentId]);
        $sectionCount = $stmt->fetch()['count'];
        
        if ($sectionCount == 0) {
            $errors[] = "Le document doit contenir au moins une section";
        }
        
        // Vérifier que les sections ont du contenu
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as empty_sections 
            FROM sections 
            WHERE document_id = :id 
            AND (contenu IS NULL OR TRIM(contenu) = '')
        ");
        $stmt->execute([':id' => $documentId]);
        $emptySections = $stmt->fetch()['empty_sections'];
        
        if ($emptySections > 0) {
            $errors[] = "$emptySections section(s) sont vides";
        }
        
    } catch (\Exception $e) {
        error_log("Erreur validation document: " . $e->getMessage());
        $errors[] = "Erreur lors de la validation";
    }
    
    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

private function saveAllSections(int $documentId, \PDO $pdo): void
{
    // Cette méthode s'assure que toutes les sections sont bien enregistrées
    // (au cas où certaines modifications n'auraient pas été sauvegardées)
    
    $stmt = $pdo->prepare("
        SELECT id, titre, contenu, ordre 
        FROM sections 
        WHERE document_id = :document_id
        ORDER BY ordre ASC
    ");
    $stmt->execute([':document_id' => $documentId]);
    $sections = $stmt->fetchAll();
    
    foreach ($sections as $section) {
        // Mettre à jour chaque section pour s'assurer qu'elle est bien enregistrée
        $updateStmt = $pdo->prepare("
            UPDATE sections 
            SET titre = :titre, 
                contenu = :contenu, 
                ordre = :ordre,
                updated_at = NOW()
            WHERE id = :id
        ");
        $updateStmt->execute([
            ':titre' => $section['titre'],
            ':contenu' => $section['contenu'],
            ':ordre' => $section['ordre'],
            ':id' => $section['id']
        ]);
    }
}

private function createSubmissionHistory(int $documentId, \PDO $pdo): void
{
    // Créer un enregistrement d'historique pour tracer la soumission
    $stmt = $pdo->prepare("
        INSERT INTO document_history (document_id, action, user_id, created_at, details)
        VALUES (:document_id, 'soumission', :user_id, NOW(), :details)
    ");
    
    $details = json_encode([
        'action' => 'Document soumis pour validation',
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ]);
    
    $stmt->execute([
        ':document_id' => $documentId,
        ':user_id' => $_SESSION['user_id'],
        ':details' => $details
    ]);
}

    private function service(): RedacteurService
    {
        $user = requireAuthenticatedUser();
        $currentUserId = $user ? (int)$user['id'] : 0;

        if ($currentUserId === 0) {
            throw new \Exception("Utilisateur non authentifié");
        }

        return new RedacteurService(
            $this->documents,
            $this->sections,
            $this->versions,
            $this->history,
            $this->permissions,
            $currentUserId
        );
    }

    private function jsonInput(): array
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }

    private function has(array $data, array $keys): bool
    {
        foreach ($keys as $k) {
            if (!array_key_exists($k, $data)) return false;
        }
        return true;
    }


    
}