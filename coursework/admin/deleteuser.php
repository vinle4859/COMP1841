<?php
include '../includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'UserDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

try {
    $user_id = (int) post_or_redirect('user_id', 'users.php');
    deleteUser($pdo, $user_id);
    header('Location: users.php');
    exit;
} catch (PDOException $e) {
    $title = "An error has occured";
    $output = 'Database error: ' . $e->getMessage();
}

if (!empty($output)) {
    include ADMIN_TEMPLATES . 'layout.html.php';
}
?>
