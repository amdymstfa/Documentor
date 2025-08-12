<?php

namespace App\Models ;

use PDO ;

class Test {

    private PDO $pdo ;

    public function __construct(PDO $pdo ){
        $this->pdo = $pdo ;
    }

    public function getRedacteuDocument(){
        $req = "select u.nom as nom , d.titre as titre from utilisateurs u join documents d on u.id = d.auteur_id";

        $stmt = $this->pdo->prepare($req);
        $stmt->execute();

        $res = $stmt->fetcAll(FETCH_ASSOC);
    }
}