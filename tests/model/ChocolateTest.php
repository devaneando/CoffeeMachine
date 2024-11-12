<?php

namespace tests\model;

use model\AbstractDrink;
use model\Chocolate;

class ChocolateTest extends AbstractDrinkTest
{
    protected int $expectedPrice = 5;
    protected string $expectedName = 'Chocolate';

    protected function getObject(): AbstractDrink
    {
        return new Chocolate();
    }
}
