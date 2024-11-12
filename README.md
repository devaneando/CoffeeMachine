# README

This project implements a coffee machine based on the following specifications:

* A coffee button that returns a `Coffee` object. Price: `2` coins
* A tea button that returns a `Tea` object. Price: `3` coins
* A chocolate button that returns a `Chocolate` object. Price: `5` coins
* A button to select sugar level from `0 to 4` to be added to the final drink
* A button to select milk level from `0 to 4` to be added to the final drink
* A slot for adding money
* A display showing the current amount
* A button to retrieve the full amount

## Installation

Clone the repository.

To run the code, simply execute:

```bash
reset && ./CoffeeMachine.php
```

To run the tests, execute:

```bash
reset && ./runTests.php
```

## Challenges

Initially, I wasn’t sure if `CoffeeMachine` was meant to act as a data transfer object (DTO) that would be processed by
a separate machine handler. Ultimately, I decided that the `CoffeeMachine` class should represent the machine itself,
handling direct user input.

I also wasn’t certain if the project should be an API or web app, but remembering the interview where you mentioned
minimal reliance on frameworks, I chose to implement it in vanilla PHP.

For simplicity and speed, I opted for a command-line interface, reading single characters as if they were button presses
on a physical machine, based on your specifications.

Since this is a CLI application, there’s no need to return the actual `Coffee`, `Tea`, or `Chocolate` objects for
display. However, to meet the requirements, `CoffeeMachine::getDrink()` does return these objects, and it outputs
confirmation to the console.

## Implementation

The obvious approach would be to use a factory pattern, but since that was restricted, I implemented a simplified MVC
pattern:

* The `CoffeeMachine` class acts as the **controller** and main entry point via the `getDrink()` method.
* Data is abstracted by models that implement `model\DrinkInterface`.
* The logic is encapsulated in `manager\DrinkManager`.
* `helper\PromptHelper` acts as a view helper, formatting outputs for the command line using `sprintf` to simulate
  templating.

In this structure, `CoffeeMachine` serves as the entry point and controller, coordinating user actions and managing
output through helper classes.
