<?php

namespace model;

use Exception;

interface DrinkInterface
{
    public function getPrice(): int;

    public function getName(): string;

    public function getMaxSugar(): int;

    public function getMaxMilk(): int;

    public function getAmount(): int;

    /**
     * @throws Exception
     */
    public function setAmount(int $amount): void;

    public function getChange(): int;

    public function getSugar(): int;

    /**
     * @throws Exception
     */
    public function setSugar(int $sugar): void;

    public function getMilk(): int;

    /**
     * @throws Exception
     */
    public function setMilk(int $milk): void;

    public function isPaid(): bool;
}
