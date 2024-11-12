<?php

namespace Helper;

use model\Chocolate;
use model\Coffee;
use model\DrinkInterface;
use model\Tea;

class PromptHelper
{
    public function printMachine(?DrinkInterface $drink, int $deposit, ?string $error): void
    {
        $tea = new Tea();
        $coffee = new Coffee();
        $chocolate = new Chocolate();

        $prompt = sprintf(
            "\n\033[34mThis is the CoffeeMachine©\033[0m\n" .
            "    \033[32mChosen drink :\033[0m %s\n" .
            "    \033[32m       Sugar :\033[0m %s\n" .
            "    \033[32m        Milk :\033[0m %s\n" .
            "    \033[32m      Amount :\033[0m %d $\n" .
            "    \033[32m      Change :\033[0m %d $\n\n" .
            "    Press \033[32m%-2s\033[0m for %-15s (\033[33m%3d\033[0m coins)\n" .
            "    Press \033[32m%-2s\033[0m for %-15s (\033[33m%3d\033[0m coins)\n" .
            "    Press \033[32m%-2s\033[0m for %-15s (\033[33m%3d\033[0m coins)\n\n" .
            "    Press \033[32m[1-9]\033[0m to add coins.\n" .
            "    Press \033[32ms\033[0m to add sugar.\n" .
            "    Press \033[32mm\033[0m to add milk.\n" .
            "    Press \033[32mg\033[0m to order the drink.\n" .
            "    Press \033[32mc\033[0m to cancel.\n" .
            "\n" .
            "    \033[91m%s\033[0m\n",
            $this->renderDrinkName($drink),
            $this->renderSugarBar($drink),
            $this->renderMilkBar($drink),
            $this->renderAmount($drink, $deposit),
            $this->renderChange($drink),
            't',
            $tea->getName(),
            $tea->getPrice(),
            'f',
            $coffee->getName(),
            $coffee->getPrice(),
            'o',
            $chocolate->getName(),
            $chocolate->getPrice(),
            $error ?? ''
        );

        echo $prompt;
    }

    public function orderDrink(?DrinkInterface $drink): bool
    {
        if (null === $drink || !$drink->isPaid()) {
            return false;
        }

        $prompt = "\n\033[34mThis is the CoffeeMachine©\033[0m\nHere is your coffee";

        $prompt .= $this->formatServings($drink->getSugar(), 'sugar');

        $prompt .= $this->formatServings($drink->getMilk(), 'milk', true);

        $change = $drink->getChange();
        $prompt .= match ($change) {
            0 => '',
            1 => ' Please take back your change: 1 coin.',
            default => " Please take back your change: $change coins.",
        };

        echo $prompt . "\n";

        return true;
    }

    private function formatServings(int $quantity, string $ingredient, bool $isLast = false): string
    {
        return ($isLast ? ' and' : '') . match ($quantity) {
            0 => " without $ingredient" . ($isLast ? '.' : ''),
            1 => " with a single serving of $ingredient" . ($isLast ? '.' : ''),
            default => " with $quantity servings of $ingredient" . ($isLast ? '.' : ''),
        };
    }

    private function renderDrinkName(?DrinkInterface $drink): string
    {
        return null === $drink ? 'Choose your drink!' : $drink->getName();
    }

    private function renderSugarBar(?DrinkInterface $drink): string
    {
        $block = "\u{2588}";

        if (null === $drink) {
            return '';
        }

        return str_repeat($block, $drink->getSugar());
    }

    private function renderMilkBar(?DrinkInterface $drink): string
    {
        $block = "\u{2588}";

        if (null === $drink) {
            return '';
        }

        return str_repeat($block, $drink->getMilk());
    }

    private function renderAmount(?DrinkInterface $drink, int $deposit): string
    {
        return null === $drink ? $deposit : $drink->getAmount();
    }

    private function renderChange(?DrinkInterface $drink): string
    {
        return null === $drink ? '0' : $drink->getChange();
    }

}
