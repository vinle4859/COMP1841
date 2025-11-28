<?php
// Moved edituser into admin/ and adjusted includes
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
include '../includes/InputHelpers.php';

// Unified flow: POST uses `user_id`, GET uses `id`. Single layout include at end.
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
            // preserve submitted values
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
    include '../templates/edituser.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include '../templates/admin_layout.html.php';
