<?php

namespace tests\model;

use Exception;
use model\AbstractDrink;

abstract class AbstractDrinkTest
{
    protected int $expectedPrice = 999;
    protected string $expectedName = 'No name at all!';
    protected int $maxSugar = 4;
    protected int $maxMilk = 4;

    /**
     * @throws Exception
     */
    public function runTests(): void
    {
        echo 'Running tests for ' . static::class . "...\n";

        $this->testGetPrice();
        $this->testGetMaxMilk();
        $this->testGetMaxSugar();
        $this->testSetAndGetAmount();
        $this->testGetChange();
        $this->testSetAndGetSugar();
        $this->testSetAndGetMilk();
        $this->testIsPaid();

        echo 'All tests passed for ' . static::class . "!\n";
    }

    abstract protected function getObject(): AbstractDrink;

    /**
     * @throws Exception
     */
    protected function testGetPrice(): void
    {
        $object = $this->getObject();
        $this->assertEqual(
            $this->expectedPrice,
            $object->getPrice(),
            'The price should be ' . $this->expectedPrice . '!'
        );
    }

    /**
     * @throws Exception
     */
    protected function testGetName(): void
    {
        $object = $this->getObject();
        $this->assertEqual(
            $this->expectedName,
            $object->getName(),
            'The name should be ' . $this->expectedName . '!'
        );
    }

    /**
     * @throws Exception
     */
    protected function testGetMaxSugar(): void
    {
        $object = $this->getObject();
        $this->assertEqual($this->maxSugar, $object->getMaxSugar(), 'The max sugar is wrong!');
    }

    /**
     * @throws Exception
     */
    protected function testGetMaxMilk(): void
    {
        $object = $this->getObject();
        $this->assertEqual($this->maxMilk, $object->getMaxMilk(), 'The max milk is wrong!');
    }

    /**
     * @throws Exception
     */
    protected function testSetAndGetAmount(): void
    {
        $object = $this->getObject();
        $object->setAmount(200);
        $this->assertEqual(200, $object->getAmount(), 'The amount should be 200!');

        $expected = false;
        try {
            $object->setAmount(-100);
        } catch (Exception $ex) {
            $expected = true;
        }

        $this->assertTrue($expected, 'No negative amount allowed!');
    }

    /**
     * @throws Exception
     */
    protected function testGetChange(): void
    {
        $object = $this->getObject();
        $object->setAmount(7);
        $this->assertEqual(
            $object->getAmount() - $object->getPrice(),
            $object->getChange(),
            'The change value is wrong!'
        );
    }

    /**
     * @throws Exception
     */
    protected function testSetAndGetSugar(): void
    {
        $object = $this->getObject();
        $object->setSugar(3);
        $this->assertEqual(3, $object->getSugar(), 'The sugar value is wrong!');

        $expected = false;
        try {
            $object->setSugar(10);
        } catch (Exception $ex) {
            $expected = true;
        }
        $this->assertTrue($expected, 'More sugar than allowed!');

        $expected = false;
        try {
            $object->setSugar(-4);
        } catch (Exception $ex) {
            $expected = true;
        }
        $this->assertTrue($expected, 'Less sugar than zero!');
    }

    /**
     * @throws Exception
     */
    protected function testSetAndGetMilk(): void
    {
        $object = $this->getObject();
        $object->setMilk(4);
        $this->assertEqual(4, $object->getMilk(), 'The milk value is wrong!');

        $expected = false;
        try {
            $object->setMilk(10);
        } catch (Exception $ex) {
            $expected = true;
        }
        $this->assertTrue($expected, 'More milk than allowed!');

        $expected = false;
        try {
            $object->setMilk(-4);
        } catch (Exception $ex) {
            $expected = true;
        }
        $this->assertTrue($expected, 'Less milk than zero!');
    }

    /**
     * @throws Exception
     */
    protected function testIsPaid(): void
    {
        $object = $this->getObject();

        $object->setAmount(1);
        $this->assertFalse($object->isPaid(), 'The drink should not be paid.');

        $object->setAmount(10);
        $this->assertTrue($object->isPaid(), 'The drink should be paid.');
    }

    /**
     * @throws Exception
     */
    protected function assertEqual($firstValue, $secondValue, string $message): void
    {
        if ($firstValue !== $secondValue) {
            throw new Exception($message);
        }
    }

    /**
     * @throws Exception
     */
    protected function assertTrue($value, string $message): void
    {
        if (!$value) {
            throw new Exception($message);
        }
    }

    /**
     * @throws Exception
     */
    protected function assertFalse($value, string $message): void
    {
        if ($value) {
            throw new Exception($message);
        }
    }
}
