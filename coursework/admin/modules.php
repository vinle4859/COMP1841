<?php
/**
 * Admin - Modules List
 * Display, add, soft-delete, and restore course modules.
 */
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';

// Read messages from URL (set by addmodule.php after redirect)
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;

$modules = selectAll($pdo, 'module', true);  // Include deleted modules
$title = 'Admin - Modules';
$activePage = 'modules';
ob_start();
include ADMIN_TEMPLATES . 'modules.html.php';
$output = ob_get_clean();
include ADMIN_TEMPLATES . 'layout.html.php';
