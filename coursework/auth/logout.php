<?php
/**
 * Logout Page
 * Destroys session and redirects to home.
 */

require_once dirname(__DIR__) . '/includes/config.php';
require_once FUNCTIONS_PATH . 'SessionFunctions.php';

logoutUser();

// Redirect to home page
header('Location: ' . BASE_URL . '/index.php');
exit;
