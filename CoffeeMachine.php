#!/usr/bin/php
<?php

require_once 'autoload.php';

use Helper\PromptHelper;
use manager\DrinkManager;
use model\DrinkInterface;

class CoffeeMachine
{
    private const VALID_CHARS = ['t', 'f', 's', 'o', 'm', 'g', 'c', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    private PromptHelper $helper;
    private DrinkManager $manager;

    public function __construct()
    {
        $this->helper = new PromptHelper();
        $this->manager = new DrinkManager();
    }

    public function getDrink(): ?DrinkInterface
    {
        system('stty -icanon');

        while (true) {
            $this->helper->printMachine(
                $this->manager->getDrink(),
                $this->manager->getDeposit(),
                $this->manager->getError()
            );
            $this->manager->clearError();

            $char = strtolower(trim(fgetc(STDIN)));

            if (!in_array($char, self::VALID_CHARS)) {
                continue;
            }

            if ('g' === $char) {
                if ($this->handleOrderDrink()) {
                    return $this->manager->getDrink();
                }
                continue;
            }

            if ($this->handleOrderCancel($char)) {
                return null;
            }

            try {
                $this->processInput($char);
            } catch (Exception $ex) {
                $this->manager->setError($ex->getMessage());
            }
        }
    }

    private function handleOrderDrink(): bool
    {
        if ($this->helper->orderDrink($this->manager->getDrink())) {
            system('stty sane');
            return true;
        }
        return false;
    }

    private function handleOrderCancel(string $char): bool
    {
        if ('c' !== $char) {
            return false;
        }

        $this->helper->cancelDrink($this->manager->getDeposit());
        system('stty sane');
        return true;
    }

    private function processInput(string $input): void
    {
        match ($input) {
            't', 'o', 'f' => $this->manager->addDrink($input),
            's' => $this->manager->addSugar(),
            'm' => $this->manager->addMilk(),
            default => $this->manager->addCoins((int)$input),
        };
    }
}

$machine = new CoffeeMachine();
$drink = $machine->getDrink();
