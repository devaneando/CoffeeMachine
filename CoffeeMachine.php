#!/usr/bin/php
<?php

require_once 'autoload.php';

use model\Chocolate;

class CoffeeMachine
{
    public function __construct() {
        $choco = new Chocolate();
        var_dump($choco);
    }
}


new CoffeeMachine();
