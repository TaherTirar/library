<?php

/**
 * This is a temporary fix file that should be run before application bootstrapping
 * to fix the "Target class [web] does not exist" error
 */

// First clear the bootstrap cache files
if (file_exists(__DIR__ . '/cache/config.php')) {
    @unlink(__DIR__ . '/cache/config.php');
}

if (file_exists(__DIR__ . '/cache/routes-v7.php')) {
    @unlink(__DIR__ . '/cache/routes-v7.php');
}

// Create this file and then run from command line:
// php bootstrap/fix_container.php
// Then run: php artisan serve

echo "Bootstrap cache files have been cleared.\n";
echo "Now run: php artisan config:clear\n";
echo "Then run: php artisan serve\n";
