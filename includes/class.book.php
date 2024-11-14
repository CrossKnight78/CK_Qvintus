<?php

class Book {

    private $pdo;
    private $errorMessages = [];
    private $errorState = 0;

    function __construct($pdo) {
        $this->pdo = $pdo;
    }


    

}

?>
