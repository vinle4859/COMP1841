<?php
include '../includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'UserDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

$error = null;
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Basic validation: all fields required; validate email format; enforce password length
        if ($username === '' || $email === '' || $password === '') {
            $error = 'Please provide a username, email address and password.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters long.';
        } else {
            // addUser requires a password (NOT NULL column)
            addUser($pdo, $username, $email, $password);
            header('Location: users.php');
            exit;
        }
    }

    $title = 'Add user';
    ob_start();
    include ADMIN_TEMPLATES . 'adduser.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include ADMIN_TEMPLATES . 'layout.html.php';
?>
