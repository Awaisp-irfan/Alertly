<?php

spl_autoload_register(function ($class_name) {
    $namespace_root = 'ALERTLY\\Includes\\';
    $class_name = trim($class_name, '\\');

    // Log the class being attempted to autoload
    error_log("Autoloader: Trying to load class/trait: " . $class_name);

    if (strpos($class_name, $namespace_root) !== 0) {
        // If the class doesn't belong to ALERTLY namespace, skip
        return;
    }

    // Remove the root namespace
    $relative_class = str_replace($namespace_root, '', $class_name);

    // Check if it's a trait
    if (strpos($class_name, 'Traits') !== false) {
        // Only convert the trait name, don't include "Traits" in the filename
        $relative_class = str_replace('Traits\\', '', $relative_class);
        $relative_class = strtolower(str_replace(['\\', '_'], '-', $relative_class));
        $file_path = ALERTLY_PLUGIN_DIR . 'includes/traits/trait-' . $relative_class . '.php';
    } else {
        // Convert class name for file path
        $relative_class = strtolower(str_replace(['\\', '_'], '-', $relative_class));
        $file_path = ALERTLY_PLUGIN_DIR . 'includes/classes/class-' . $relative_class . '.php';
    }

    // Log the file path being checked
    error_log("Autoloader: Loading file path: " . $file_path);

    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        error_log("Autoloader: File not found: " . $file_path);
    }
});
