<?php
/**
 * Admin - Edit User
 * Update username, email, password, or role for any user.
 */
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'UserDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

$error = null;

// Get user ID from POST or GET
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = (int) post_or_redirect('user_id', 'users.php');
} else {
    $user_id = (int) get_or_redirect('id', 'users.php');
}

$user = getUser($pdo, $user_id);
if (!$user) {
    header('Location: users.php');
    exit;
}

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        
        if ($username === '' || $email === '') {
            $error = 'Please enter a username and email address.';
            $user['username'] = $username;
            $user['email'] = $email;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
            $user['username'] = $username;
            $user['email'] = $email;
        } else {
            try {
                updateUser($pdo, $user_id, $username, $email);
                header('Location: users.php');
                exit;
            } catch (PDOException $e) {
                $error = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

// Render page
$title = 'Edit user';
ob_start();
include ADMIN_TEMPLATES . 'edituser.html.php';
$output = ob_get_clean();
include ADMIN_TEMPLATES . 'layout.html.php';
