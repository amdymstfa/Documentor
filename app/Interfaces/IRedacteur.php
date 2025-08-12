<?php

namespace App\Interfaces;

interface IRedacteur
{
    // document
    public function createDocument(string $titre, string $template) : IDocument;
    public function updateDocument(IDocument $document) : bool;
    public function deleteDocument(int $documentId) : bool;

    //section
    public function addSection(int $documentId, ISection $section) : bool;
    public function updateSection(ISection $section) : bool;
    public function deleteSection(int $sectionId): bool;

    // actions sur le document 
    public function submitForValidation(int $documentId) : bool ;
    public function canEdit(int $documentId) : bool ;
}