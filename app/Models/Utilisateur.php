<?php

namespace App\Models ;

use PDO;

class Utilisateur {
    private PDO $pdo ;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo ;
    }

    // check email
   public function emailExist(string $email) : bool{
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetchColumn() > 0;
    }

    // create new user
    public function create(array $data): int {
    $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe, role_id) VALUES (:nom, :email, :mot_de_passe, :role_id)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $data['nom'],
        ':email' => $data['email'],
        ':mot_de_passe' => $data['mot_de_passe'],
        ':role_id' => $data['role_id'],
    ]);
    return (int) $this->pdo->lastInsertId();
    }

     // find user by email
    public function findByEmail(string $email): ?array {
        $stmt = $this->pdo->prepare("SELECT id, nom, email, mot_de_passe, role_id FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user ?: null;
    }

    // find user by id
    public function findById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT id, nom, email, role_id FROM utilisateurs WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user ?: null;
    }

}