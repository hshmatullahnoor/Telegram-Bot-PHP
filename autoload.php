<?php

// make a autoload function to load the classes from the Classes directory
// usage example: use Classes\Database\Connection;

function autoload($className) {
    // Convert the namespace to a file path
    $filePath = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';

    // Check if the file exists
    if (file_exists($filePath)) {
        // Include the file
        require_once $filePath;
    } else {
        // Handle the error
        throw new Exception("Class file not found: " . $filePath);
    }
}

// Register the autoload function

spl_autoload_register('autoload');