<?php
/**
 * Application Configuration
 * Defines path constants used throughout the application.
 * Include this file FIRST in all PHP files.
 * 
 * This file auto-detects if called from root or admin folder.
 */

// Determine the coursework root directory
// Works whether included from root or from admin/
$configDir = dirname(__FILE__);  // This is always /includes/
define('ROOT_PATH', dirname($configDir) . DIRECTORY_SEPARATOR);

// Include paths
define('INCLUDES_PATH', ROOT_PATH . 'includes' . DIRECTORY_SEPARATOR);
define('FUNCTIONS_PATH', INCLUDES_PATH . 'functions' . DIRECTORY_SEPARATOR);

// Template paths
define('TEMPLATES_PATH', ROOT_PATH . 'templates' . DIRECTORY_SEPARATOR);
define('PUBLIC_TEMPLATES', TEMPLATES_PATH . 'public' . DIRECTORY_SEPARATOR);
define('ADMIN_TEMPLATES', TEMPLATES_PATH . 'admin' . DIRECTORY_SEPARATOR);

// Image upload path
define('IMAGES_PATH', ROOT_PATH . 'images' . DIRECTORY_SEPARATOR);
