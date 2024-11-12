<?php

// Define the base directories for the namespace prefix
define('SRC_BASE_DIR', __DIR__ . '/src/');
define('TESTS_BASE_DIR', __DIR__ . '/tests/');

// Autoloader function
spl_autoload_register(function ($class): void {
    // Determine the base directory based on the namespace
    if (str_starts_with($class, 'tests\\')) {
        $baseDir = TESTS_BASE_DIR;
        $relativeClass = substr($class, strlen('tests\\')); // Remove 'tests\' from the start
    } else {
        $baseDir = SRC_BASE_DIR;
        $relativeClass = $class;
    }

    // Convert namespace to full file path
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    // Check if the file exists, then include it
    if (file_exists($file)) {
        require_once $file;
    } else {
        throw new Exception("Class {$class} not found in src or tests directories.");
    }
});
