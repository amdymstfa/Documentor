<?php


namespace App\Services ;

use App\Models\Utilisateur;


class UserService {

    private Utilisateur $userModel ;

    public function __construct(Utilisateur $userModel){
        $this->userModel = $userModel;
    }

    public function register(array $data){
        // empty field
        if (empty($data['nom']) || empty($data['email']) || empty($data['mot_de_passe'])){
            throw new InvalidArgumentException("Tous les champs sont obligatoires");
        }

        // email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            throw new InvalidArgumentException("Le format est invalid");
        }

        // email exist
        if ($this->userModel->emailExist($data['email'])){
            throw new InvalidArgumentException("Email deja utilise");
        }


        // hash
        $data['mot_de_passe'] = password_hash($data['mot_de_passe'], PASSWORD_BCRYPT);

        // default role 
        $data['role_id'] = 2 ;  

        // create user 
        // $this->userModel->create($data);

        $userId = $this->userModel->create($data);
        return $userId;
    }

     public function login(array $credentials): array {
        if (empty($credentials['email']) || empty($credentials['mot_de_passe'])) {
            throw new \InvalidArgumentException("Email et mot de passe sont obligatoires");
        }

        if (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Le format de l'email est invalide");
        }

        $user = $this->userModel->findByEmail($credentials['email']);

        if (!$user) {
            throw new \InvalidArgumentException("Identifiants incorrects");
        }

        if (!password_verify($credentials['mot_de_passe'], $user['mot_de_passe'])) {
            throw new \InvalidArgumentException("Identifiants incorrects");
        }

        
        return [
            'id' => $user['id'],
            'nom' => $user['nom'],
            'email' => $user['email'],
            'role_id' => $user['role_id']
        ];
    }
}