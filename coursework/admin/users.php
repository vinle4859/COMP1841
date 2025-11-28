<?php
// Admin users list
include '../includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';

// Include deleted users to show full list with status
$users = selectAll($pdo, 'user_account', true);
$title = 'Admin - Users';
$activePage = 'users';
ob_start();
include ADMIN_TEMPLATES . 'users.html.php';
$output = ob_get_clean();
include ADMIN_TEMPLATES . 'layout.html.php';
