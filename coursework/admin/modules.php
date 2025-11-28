<?php
// Admin modules list - display only, form posts to addmodule.php
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
include '../includes/InputHelpers.php';

// Read messages from URL (set by addmodule.php after redirect)
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;

$modules = selectAll($pdo, 'module', true);  // Include deleted modules
$title = 'Admin - Modules';
$activePage = 'modules';
ob_start();
include '../templates/admin_modules.html.php';
$output = ob_get_clean();
include '../templates/admin_layout.html.php';
