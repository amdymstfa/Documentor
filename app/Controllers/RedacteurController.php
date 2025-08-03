<?php

namespace App\Controllers;

use App\Services\RedacteurService;
use App\Utils\JsonResponse;
use App\Utils\Request;

class RedacteurController
{
    private RedacteurService $redacteurService;

    public function __construct(RedacteurService $redacteurService)
    {
        $this->redacteurService = $redacteurService;
    }

    public function getMesDocuments(): void
    {
        try {
            $userId = $_SESSION['user_id'] ?? null;
            if (!$userId) {
                JsonResponse::error('Non authentifié', 401);
                return;
            }

            $documents = $this->redacteurService->getMesDocuments($userId);
            $documentsArray = array_map(fn($doc) => $doc->toArray(), $documents);

            JsonResponse::success($documentsArray);
        } catch (\Exception $e) {
            JsonResponse::error($e->getMessage(), 500);
        }
    }

    public function creerDocument(): void
    {
        try {
            $data = Request::getJsonData();
            $data['user_id'] = $_SESSION['user_id'] ?? null;

            if (!$data['user_id']) {
                JsonResponse::error('Non authentifié', 401);
                return;
            }

            if (empty($data['titre'])) {
                JsonResponse::error('Le titre est requis', 400);
                return;
            }

            $document = $this->redacteurService->creerDocument($data);
            JsonResponse::success($document->toArray(), 'Document créé avec succès');
        } catch (\Exception $e) {
            JsonResponse::error($e->getMessage(), 500);
        }
    }

    public function modifierDocument(int $documentId): void
    {
        try {
            $data = Request::getJsonData();
            $document = $this->redacteurService->modifierDocument($documentId, $data);
            JsonResponse::success($document->toArray(), 'Document modifié avec succès');
        } catch (\Exception $e) {
            JsonResponse::error($e->getMessage(), 500);
        }
    }

    public function supprimerDocument(int $documentId): void
    {
        try {
            $success = $this->redacteurService->supprimerDocument($documentId);
            if ($success) {
                JsonResponse::success(null, 'Document supprimé avec succès');
            } else {
                JsonResponse::error('Erreur lors de la suppression', 500);
            }
        } catch (\Exception $e) {
            JsonResponse::error($e->getMessage(), 500);
        }
    }

    public function ajouterSection(int $documentId): void
    {
        try {
            $data = Request::getJsonData();
            $data['document_id'] = $documentId;
            
            $section = $this->redacteurService->ajouterSection($documentId, $data);
            JsonResponse::success($section->toArray(), 'Section ajoutée avec succès');
        } catch (\Exception $e) {
            JsonResponse::error($e->getMessage(), 500);
        }
    }

    public function modifierSection(int $sectionId): void
    {
        try {
            $data = Request::getJsonData();
            $section = $this->redacteurService->modifierSection($sectionId, $data);
            JsonResponse::success($section->toArray(), 'Section modifiée avec succès');
        } catch (\Exception $e) {
            JsonResponse::error($e->getMessage(), 500);
        }
    }

    public function soumettreValidation(int $documentId): void
    {
        try {
            $success = $this->redacteurService->soumettreValidation($documentId);
            if ($success) {
                JsonResponse::success(null, 'Document soumis pour validation');
            } else {
                JsonResponse::error('Erreur lors de la soumission', 500);
            }
        } catch (\Exception $e) {
            JsonResponse::error($e->getMessage(), 500);
        }
    }
}