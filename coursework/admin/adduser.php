<?php
/**
 * Admin - Add User
 * Create new user accounts (students or admins).
 */
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'UserDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

$error = null;

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username === '' || $email === '' || $password === '') {
            $error = 'Please provide a username, email address and password.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters long.';
        } else {
            try {
                addUser($pdo, $username, $email, $password);
                header('Location: users.php');
                exit;
            } catch (PDOException $e) {
                $error = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

// Render page
$title = 'Add user';
ob_start();
include ADMIN_TEMPLATES . 'adduser.html.php';
$output = ob_get_clean();
include ADMIN_TEMPLATES . 'layout.html.php';
