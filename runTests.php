#!/usr/bin/php
<?php

require_once 'autoload.php';

use tests\model\ChocolateTest;
use tests\model\CoffeeTest;
use tests\model\TeaTest;

$test = new ChocolateTest();
try {
    $test->runTests();
} catch (Exception $ex) {
    echo "\033[91m {$ex->getMessage()} \033[0m\n";
}
echo("\n");

$test = new CoffeeTest();
try {
    $test->runTests();
} catch (Exception $ex) {
    echo "\033[91m {$ex->getMessage()} \033[0m\n";
}
echo("\n");

$test = new TeaTest();
try {
    $test->runTests();
} catch (Exception $ex) {
    echo "\033[91m {$ex->getMessage()} \033[0m\n";
}
echo("\n");
