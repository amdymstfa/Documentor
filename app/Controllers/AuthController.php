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

            // response interpretation
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Utilisateur créé avec succès',
                'id' => $userId
            ]);
        } catch (\InvalidArgumentException $e) {
            // response interpretation
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            // response interpretation
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur serveur.']);
        }
    }
}
