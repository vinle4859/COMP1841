<?php
include '../includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'UserDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

$error = null;
try {
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            updateUser($pdo, $user_id, $username, $email);
            header('Location: users.php');
            exit;
        }
    }

    $title = 'Edit user';
    ob_start();
    include ADMIN_TEMPLATES . 'edituser.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include ADMIN_TEMPLATES . 'layout.html.php';
