<?php

namespace App\Interfaces ; 

interface IValidateur {

    public function getDocumentsToValidate() : array;
    public function validateDocument(int $documentId) : bool ;
    public function rejectDocument( int $documentId, string $commentaire) : bool ;
    public function addComment( int $documentId, string $commentaire) : bool ;
    public function canValidate(int $documentId) :  bool ;

}