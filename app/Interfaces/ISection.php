<?php

namespace App\Interfaces;

interface ISection
{
   public function getId() : int ;
   public function getTitre() : string ;
   public function getContent() : string ;

   public function getParentId() : ? int ;
   public function addChild(ISection $child): void;

   public function getChildren() : array ;
   public function removeChildren(int $childId) : bool ;

   public function getOrdre() : int ;
}