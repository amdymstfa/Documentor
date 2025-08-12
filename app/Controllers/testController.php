<?php

namespace App\Controllers ;

use App\Models\Test ;


class testController {

    private Test $test ;

    public function __construct(Test $test) {
        $this->test = $test ;
    }

    public function getRedac(){
        $redacteur = $this->test->getRedacteuDocument();
        header('Content-Type: application/json');
        
    }
}