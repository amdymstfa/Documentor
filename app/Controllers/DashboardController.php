<?php

namespace App\Controllers;

use App\Services\RoleService;

class DashboardController {
    private RoleService $roleService;

    public function __construct(RoleService $roleService) {
        $this->roleService = $roleService;
    }

    /**
     * Affiche le dashboard en fonction de l'ID du rôle
     */
    public function show(int $roleId): void {
        $roleInfo = $this->roleService->getRoleInfo($roleId);

        if (!$roleInfo) {
            http_response_code(404);
            echo "Rôle introuvable.";
            return;
        }

        // Mapping des rôles vers les noms de fichiers (sans accents)
        $roleToViewMap = [
            'Rédacteur' => 'redacteur',
            'Validateur' => 'validateur', 
            'Client' => 'client',
            'Générateur' => 'generateur'
        ];
        
        $viewName = $roleToViewMap[$roleInfo['nom']] ?? strtolower($roleInfo['nom']);

        $this->renderView($viewName, [
            'title' => 'Dashboard ' . $roleInfo['nom'],
            'role' => $roleInfo['nom'],
            'permissions' => $roleInfo['permissions'] ?? []
        ]);
    }

    /**
     * Dashboard par défaut
     */
    public function index(): void {
        $this->renderView('default', [
            'title' => 'Dashboard',
            'message' => 'Veuillez vous connecter pour accéder à votre espace'
        ]);
    }

    /**
     * Méthode pour rendre une vue - CHEMIN CORRIGÉ
     */
    private function renderView(string $viewName, array $data = []): void {
        // CHEMIN CORRIGÉ : depuis /app/Controllers/ vers /views/dashboard/
        $viewPath = __DIR__ . '/../../views/dashboard/' . $viewName . '.php';
        
        // Debug pour voir le chemin exact
        error_log("Tentative de chargement de la vue : " . $viewPath);
        error_log("Le fichier existe : " . (file_exists($viewPath) ? 'OUI' : 'NON'));
        
        if (!file_exists($viewPath)) {
            // Essayer le chemin depuis la racine du projet
            $alternativeViewPath = $_SERVER['DOCUMENT_ROOT'] . '/../views/dashboard/' . $viewName . '.php';
            error_log("Chemin alternatif testé : " . $alternativeViewPath);
            
            if (file_exists($alternativeViewPath)) {
                $viewPath = $alternativeViewPath;
            } else {
                // Dernier essai avec un chemin absolu basé sur le projet
                $projectRoot = dirname(dirname(__DIR__)); // Remonte à la racine du projet
                $finalViewPath = $projectRoot . '/views/dashboard/' . $viewName . '.php';
                error_log("Chemin final testé : " . $finalViewPath);
                
                if (file_exists($finalViewPath)) {
                    $viewPath = $finalViewPath;
                } else {
                    http_response_code(404);
                    echo json_encode([
                        'error' => 'Vue non trouvée',
                        'view_name' => $viewName,
                        'attempted_paths' => [
                            $viewPath,
                            $alternativeViewPath,
                            $finalViewPath
                        ]
                    ]);
                    return;
                }
            }
        }

        // Extraction des données pour la vue
        extract($data);
        
        // Inclusion de la vue
        include $viewPath;
    }
}