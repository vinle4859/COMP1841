<?php
// Admin users list and delete (moved into admin/)
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';

// Users listing controller (delete moved to `deleteuser.php`)
// Include deleted users to show full list with status
$users = selectAll($pdo, 'user_account', true);
$title = 'Admin - Users';
$activePage = 'users';
ob_start();
include '../templates/admin_users.html.php';
$output = ob_get_clean();
include '../templates/admin_layout.html.php';
