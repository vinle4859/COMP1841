<?php
/**
 * Admin - Users List
 * Display all users with search, soft-delete, and restore functionality.
 */
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'UserDbFunctions.php';

// Get search parameter (minimum 2 characters)
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : null;

if ($searchTerm && strlen($searchTerm) < 2) {
    $searchTerm = null;
}

if ($searchTerm) {
    $users = searchUsers($pdo, $searchTerm);
} else {
    // Include deleted users to show full list with status
    $users = selectAll($pdo, 'user_account', true);
}

$title = 'Admin - Users';
$activePage = 'users';
ob_start();
include ADMIN_TEMPLATES . 'users.html.php';
$output = ob_get_clean();
include ADMIN_TEMPLATES . 'layout.html.php';
