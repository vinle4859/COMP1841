<?php
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true, 'csrf' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'UserDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

try {
    $user_id = (int) post_or_redirect('user_id', 'users.php');
    
    // Prevent admin from deleting their own account
    if ($user_id === getCurrentUserId()) {
        header('Location: users.php?error=' . urlencode('Admin accounts cannot be deleted.'));
        exit;
    }
    
    deleteUser($pdo, $user_id);
    header('Location: users.php');
    exit;
} catch (PDOException $e) {
    $title = "An error has occured";
    $output = 'Database error: ' . $e->getMessage();
    include ADMIN_TEMPLATES . 'layout.html.php';
}
