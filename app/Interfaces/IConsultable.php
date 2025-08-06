<?php

namespace App\Interfaces ;

interface IConsultable {
    public function getAvailableDocument() : array ;
    public function viewDocument(int $docementId)  : ? IDocumnet;
    public function addFeedBack(int $docementId, string $feedback) : bool;
    public function canView(int $docementId) : bool ;
}