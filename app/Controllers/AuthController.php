<?php

namespace App\Controllers;

use App\Services\UserService;

class AuthController {
    private UserService $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function register() : void {
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!$input) {
                throw new \InvalidArgumentException("Données JSON invalides ou absentes.");
            }

            $userId = $this->userService->register($input);

            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Utilisateur créé avec succès',
                'id' => $userId
            ]);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur serveur.']);
        }
    }

    public function login(): void {
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input) {
                throw new \InvalidArgumentException("Données JSON invalides ou absentes.");
            }

            $user = $this->userService->login($input);

            // ✅ CRÉER LA SESSION - C'ÉTAIT LE PROBLÈME !
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = [
                'id' => $user['id'],
                'nom' => $user['nom'],
                'email' => $user['email'],
                'role_id' => $user['role_id'],
                'role_nom' => $user['role_nom'] ?? 'Utilisateur'
            ];

            // Déterminer l'URL de redirection selon le rôle
            $redirectUrl = $this->getRedirectUrlByRole($user['role_id']);

            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Connexion réussie',
                'user' => [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'email' => $user['email'],
                    'role_id' => $user['role_id'],
                    'role_nom' => $user['role_nom'] ?? 'Utilisateur',
                    'redirect_url' => $redirectUrl
                ]
            ]);

        } catch (\InvalidArgumentException $e) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur serveur.']);
        }
    }

    /**
     * Détermine l'URL de redirection selon le rôle utilisateur
     */
    private function getRedirectUrlByRole(int $roleId): string {
        switch ($roleId) {
            case 1: return '/dashboard/redacteur';
            case 2: return '/dashboard/validateur';
            case 3: return '/dashboard/client';
            case 4: return '/dashboard/generateur';
            default: return '/dashboard';
        }
    }
}