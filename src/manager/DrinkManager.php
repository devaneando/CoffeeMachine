<?php

namespace manager;

use Exception;
use model\Chocolate;
use model\Coffee;
use model\DrinkInterface;
use model\Tea;

class DrinkManager
{
    private const DRINK_CHARS = ['t', 'o', 'f'];

    private ?DrinkInterface $drink = null;
    private int $deposit = 0;
    private ?string $error = null;

    public function addDrink(string $input): void
    {
        if (!in_array($input, self::DRINK_CHARS)) {
            return;
        }

        $this->drink = match ($input) {
            't' => new Tea(),
            'o' => new Chocolate(),
            'f' => new Coffee(),
        };

        try {
            $this->drink->setAmount($this->deposit);
        } catch (Exception $ex) {
            $this->error = $ex->getMessage();
        }
    }

    public function addSugar(): void
    {
        if (null === $this->drink) {
            $this->error = 'Choose drink first!';
            return;
        }

        $sugar = $this->drink->getSugar() + 1;
        if ($this->drink->getMaxSugar() < $sugar) {
            $sugar = 0;
        }

        try {
            $this->drink->setSugar($sugar);
        } catch (Exception $ex) {
            $this->error = $ex->getMessage();
        }
    }

    public function addMilk(): void
    {
        if (null === $this->drink) {
            $this->error = 'Choose drink first!';
            return;
        }

        $milk = $this->drink->getMilk() + 1;
        if ($this->drink->getMaxMilk() < $milk) {
            $milk = 0;
        }

        try {
            $this->drink->setMilk($milk);
        } catch (Exception $ex) {
            $this->error = $ex->getMessage();
        }
    }

    public function addCoins(int $amount): void
    {
        $this->deposit += $amount;

        try {
            $this->drink?->setAmount($this->deposit);
        } catch (Exception $ex) {
            $this->error = $ex->getMessage();
        }
    }

    public function getDrink(): ?DrinkInterface
    {
        return $this->drink;
    }

    public function getDeposit(): int
    {
        return $this->deposit;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function setError(?string $error = null): ?string
    {
        return $this->error = $error;
    }

    public function clearError(): void
    {
        $this->error = null;
    }
}
