<?php
try {
    include '../includes/DatabaseConnection.php';
    include '../includes/DatabaseFunctions.php';
    include '../includes/InputHelpers.php';
    $user_id = (int) post_or_redirect('user_id', 'users.php');
    deleteUser($pdo, $user_id);
    header('Location: users.php');
    exit;
} catch (PDOException $e) {
    $title = "An error has occured";
    $output = 'Database error: ' . $e->getMessage();
}

if (!empty($output)) {
    include '../templates/admin_layout.html.php';
}
?>
