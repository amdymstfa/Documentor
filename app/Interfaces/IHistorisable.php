<?php

namespace App\Interfaces ;

interface IHistorisable {

    public function getHIstory() : array ;
    public function addToHistory(string $action, array $data) : void; 
    public function getActionByUser(int $userId) : array;
    public function getActionByDate(string $date)  : array ;
}

