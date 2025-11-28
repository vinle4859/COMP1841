<?php
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
include '../includes/InputHelpers.php';

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
        // preserve submitted values for re-render
        // $username and $email already set above and will be used by the template
    }

    $title = 'Add user';
    ob_start();
    include '../templates/admin_adduser.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include '../templates/admin_layout.html.php';
?>
