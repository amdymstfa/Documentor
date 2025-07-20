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

}