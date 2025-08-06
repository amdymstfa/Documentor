<?php

namespace App\Interfaces;

interface IDocument {

    // format du document
    public function getId() : int;
    public function getTitre() : string ;
    public function getStatus() : string ;

    // sections
    public function addSection(ISection $section): void;
    public function getSection() : array ;
    public function removeSection(int $sectionId) : bool ;

    // action sur les sections
    public function getRedacteurId() : int;
    public function canEditBy(int $user) : bool ;
}