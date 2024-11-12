<?php

namespace tests\model;

use model\AbstractDrink;
use model\Coffee;

class CoffeeTest extends AbstractDrinkTest
{
    protected int $expectedPrice = 2;
    protected string $expectedName = 'Coffee';

    protected function getObject(): AbstractDrink
    {
        return new Coffee();
    }
}
