<?php

namespace App\Services;

use App\Models\Utilisateur;
use App\Services\RoleService;

class UserService {
    private Utilisateur $userModel;
    private RoleService $roleService;

    public function __construct(Utilisateur $userModel, RoleService $roleService) {
        $this->userModel = $userModel;
        $this->roleService = $roleService;
    }

    public function register(array $data) {
        // Validation des champs obligatoires
        if (empty($data['nom']) || empty($data['email']) || empty($data['mot_de_passe']) || empty($data['role_id'])) {
            throw new \InvalidArgumentException("Tous les champs sont obligatoires");
        }

        // Validation du format email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Le format de l'email est invalide");
        }

        // Validation de la longueur du mot de passe
        if (strlen($data['mot_de_passe']) < 6) {
            throw new \InvalidArgumentException("Le mot de passe doit contenir au moins 6 caractères");
        }

        // Validation du role_id (1-4 selon le cahier des charges)
        if (!in_array($data['role_id'], ['1', '2', '3', '4'])) {
            throw new \InvalidArgumentException("Rôle invalide sélectionné");
        }

        // Vérification si l'email existe déjà
        if ($this->userModel->emailExist($data['email'])) {
            throw new \InvalidArgumentException("Cet email est déjà utilisé");
        }

        // Hash du mot de passe
        $data['mot_de_passe'] = password_hash($data['mot_de_passe'], PASSWORD_BCRYPT);

        // Conversion du role_id en entier (GARDE LE CHOIX UTILISATEUR - V1)
        $data['role_id'] = (int) $data['role_id'];

        // Création de l'utilisateur
        $userId = $this->userModel->create($data);

        return $userId;
    }

    public function login(array $credentials): array {
        // Validation des champs requis
        if (empty($credentials['email']) || empty($credentials['mot_de_passe'])) {
            throw new \InvalidArgumentException("Email et mot de passe sont obligatoires");
        }

        // Validation du format email
        if (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Le format de l'email est invalide");
        }

        // Récupération de l'utilisateur par email
        $user = $this->userModel->findByEmail($credentials['email']);
        if (!$user) {
            throw new \InvalidArgumentException("Identifiants incorrects");
        }

        // Vérification du mot de passe
        if (!password_verify($credentials['mot_de_passe'], $user['mot_de_passe'])) {
            throw new \InvalidArgumentException("Identifiants incorrects");
        }

        // Retour des données utilisateur avec redirection
        return [
            'id' => $user['id'],
            'nom' => $user['nom'],
            'email' => $user['email'],
            'role_id' => $user['role_id'],
            'redirect_url' => $this->roleService->getRedirectPath($user['role_id']),
            'role_info' => $this->roleService->getRoleInfo($user['role_id'])
        ];
    }
}