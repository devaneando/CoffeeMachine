#!/usr/bin/php
<?php

require_once 'autoload.php';

use Helper\PromptHelper;
use model\Chocolate;
use model\Coffee;
use model\DrinkInterface;
use model\Tea;

class CoffeeMachine
{
    private ?DrinkInterface $drink = null;
    private ?string $error = null;
    private int $deposit = 0;

    public function __construct()
    {
        $helper = new PromptHelper();
        $this->readPrompt($helper);
    }

    private function readPrompt(PromptHelper $helper): void
    {
        $validChars = ['t', 'f', 's', 'o', 'm', 'g', 'c', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        system('stty -icanon');

        while (true) {
            $helper->printMachine($this->drink, $this->deposit, $this->error);
            $this->error = null;
            $char = fgetc(STDIN);
            $char = strtolower(trim($char));

            if (!in_array($char, $validChars)) {
                continue;
            }

            if ('g' === $char) {
                if (null !== $this->orderDrink($helper)) {
                    system('stty sane');

                    return;
                }

                continue;
            }

            if ('c' === $char) {
                system('stty sane');

                return;
            }

            $this->handle($char);
        }

        system('stty sane');
    }

    private function orderDrink(PromptHelper $helper): ?DrinkInterface
    {
        return !$helper->orderDrink($this->drink) ? null : $this->drink;
    }

    private function handle(string $input): void
    {
        try {
            $this->addDrink($input);
            $this->addSugar($input);
            $this->addMilk($input);
            $this->addCoins($input);
        } catch (Exception $ex) {
            $this->error = $ex->getMessage();
        }
    }

    private function addDrink(string $input): void
    {
        if (!in_array($input, ['t', 'o', 'f'])) {
            return;
        }

        $this->drink = match ($input) {
            't' => new Tea(),
            'o' => new Chocolate(),
            'f' => new Coffee()
        };
        $this->drink->setAmount($this->deposit);
    }

    /**
     * @throws Exception
     */
    private function addSugar(string $input): void
    {
        if ('s' !== $input) {
            return;
        }

        if (null === $this->drink) {
            $this->error = 'Choose drink first!';

            return;
        }

        $sugar = $this->drink->getSugar() + 1;
        if ($this->drink->getMaxSugar() < $sugar) {
            $sugar = 0;
        }

        $this->drink->setSugar($sugar);
    }

    /**
     * @throws Exception
     */
    private function addMilk(string $input): void
    {
        if ('m' !== $input) {
            return;
        }

        if (null === $this->drink) {
            $this->error = 'Choose drink first!';

            return;
        }

        $milk = $this->drink->getMilk() + 1;
        if ($this->drink->getMaxMilk() < $milk) {
            $milk = 0;
        }

        $this->drink->setMilk($milk);
    }

    /**
     * @throws Exception
     */
    private function addCoins(string $input): void
    {
        if (!is_numeric($input)) {
            return;
        }

        $this->deposit += (int)$input;
        $this->drink?->setAmount($this->deposit);
    }
}

new CoffeeMachine();
