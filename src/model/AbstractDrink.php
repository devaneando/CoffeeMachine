<?php

namespace model;

use Exception;

abstract class AbstractDrink implements DrinkInterface
{
    // If somebody forgets to override, the price will be really high!
    protected int $price = 999;
    protected string $name = 'No name';
    protected int $maxSugar = 4;
    protected int $maxMilk = 4;

    private int $amount = 0;
    private int $change = 0;
    private int $sugar = 0;
    private int $milk = 0;

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxSugar(): int
    {
        return $this->maxSugar;
    }

    public function getMaxMilk(): int
    {
        return $this->maxMilk;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @throws Exception
     */
    public function setAmount(int $amount): void
    {
        if ($amount < 0) {
            throw new Exception('No negative amount allowed!');
        }

        $this->amount = $amount;
        $this->change = max(0, $this->amount - $this->price);
    }

    public function getChange(): int
    {
        return $this->change;
    }

    public function getSugar(): int
    {
        return $this->sugar;
    }

    /**
     * @throws Exception
     */
    public function setSugar(int $sugar): void
    {
        if ($sugar < 0 || $sugar > $this->maxSugar) {
            throw new Exception("Sugar amount must be between 0 and {$this->maxSugar}.");
        }
        $this->sugar = $sugar;
    }

    public function getMilk(): int
    {
        return $this->milk;
    }

    /**
     * @throws Exception
     */
    public function setMilk(int $milk): void
    {
        if ($milk < 0 || $milk > $this->maxMilk) {
            throw new Exception("Milk amount must be between 0 and {$this->maxMilk}.");
        }
        $this->milk = $milk;
    }

    public function isPaid(): bool
    {
        return $this->amount >= $this->price;
    }
}
