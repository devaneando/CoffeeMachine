<?php

namespace tests\model;

use model\AbstractDrink;
use model\Tea;

class TeaTest extends AbstractDrinkTest
{
    protected int $expectedPrice = 3;
    protected string $expectedName = 'Tea';

    protected function getObject(): AbstractDrink
    {
        return new Tea();
    }
}
