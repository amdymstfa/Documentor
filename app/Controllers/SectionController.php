<?php

namespace App\Controllers;

use App\Repositories\DocumentRepository;
use App\Repositories\SectionRepository;
use App\Services\VersionService;
use App\Interfaces\IHistorisable;
use App\Interfaces\IPermissionManager;
use App\Services\RedacteurService;
use App\Services\Section; 
use App\Interfaces\IVersionable;

class SectionController
{
    public function __construct(
        private DocumentRepository $documents,
        private SectionRepository $sections,
        private IVersionable $versions,
        private IHistorisable $history,
        private IPermissionManager $permissions
    ){}


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
        
        // ✅ CORRECTION : Adapter à la vraie structure de la table sections
        $sectionData = [
            'id' => 0,
            'document_id' => $documentId,
            'titre' => trim((string)$input['titre']),
            'parent_id' => $input['parent_id'] ?? null,
            'type_id' => $input['type_id'] ?? 1, // ✅ Champ obligatoire, défaut = 1
            'ordre' => $input['ordre'] ?? 0,
        ];
        
        $section = new \App\Services\Section($sectionData);
        
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

    // POST /api/documents/{documentId}/sections
    public function store(int $documentId): void
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

            // ✅ Utiliser la classe Section existante
            $sectionData = [
                'id' => 0,
                'document_id' => $documentId,
                'titre' => trim((string)$input['titre']),
                'contenu' => $input['contenu'] ?? null,
                'parent_id' => $input['parent_id'] ?? null,
                'ordre' => $input['ordre'] ?? 1,
            ];
            
            $section = new Section($sectionData);
            
            $service = $this->service();
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

    // PATCH /api/sections/{sectionId}
    public function update(int $sectionId): void
    {
        header('Content-Type: application/json');
        
        try {
            $input = $this->jsonInput();
            
            $sectionData = $this->sections->findById($sectionId);
            if (!$sectionData) {
                http_response_code(404);
                echo json_encode(['success' => false, 'error' => 'Section non trouvée']);
                return;
            }

            // ✅ Utiliser la classe Section existante
            $updatedData = array_merge($sectionData, [
                'titre' => $input['titre'] ?? $sectionData['titre'],
                'contenu' => $input['contenu'] ?? $sectionData['contenu'],
                'parent_id' => $input['parent_id'] ?? $sectionData['parent_id'],
                'ordre' => $input['ordre'] ?? $sectionData['ordre'],
            ]);
            
            $section = new Section($updatedData);
            
            $service = $this->service();
            $success = $service->updateSection($section);
            
            if (!$success) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'Modification de section refusée']);
                return;
            }

            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Section mise à jour']);
            
        } catch (\Exception $e) {
            error_log("Erreur update section: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Erreur serveur: ' . $e->getMessage()]);
        }
    }

    // DELETE /api/sections/{sectionId}
    public function destroy(int $sectionId): void
    {
        header('Content-Type: application/json');
        
        try {
            $service = $this->service();
            $success = $service->deleteSection($sectionId);

            if (!$success) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'Suppression de section refusée']);
                return;
            }
            
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Section supprimée']);
            
        } catch (\Exception $e) {
            error_log("Erreur delete section: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Erreur serveur: ' . $e->getMessage()]);
        }
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