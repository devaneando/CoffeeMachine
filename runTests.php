#!/usr/bin/php
<?php

require_once 'autoload.php';

use tests\model\ChocolateTest;
use tests\model\CoffeeTest;
use tests\model\TeaTest;

$test = new ChocolateTest();
$test->runTests();
echo("\n");

$test = new CoffeeTest();
$test->runTests();
echo("\n");

$test = new TeaTest();
$test->runTests();
echo("\n");
