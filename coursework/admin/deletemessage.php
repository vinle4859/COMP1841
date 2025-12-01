<?php
/**
 * Admin - Delete Message (POST handler)
 * Permanently removes a contact form submission.
 */
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true, 'csrf' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'MessageDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

try {
    $message_id = (int) post_or_redirect('message_id', 'messages.php');
    deleteMessage($pdo, $message_id);
    header('Location: messages.php');
    exit;
} catch (PDOException $e) {
    $title = "An error has occured";
    $output = 'Database error: ' . $e->getMessage();
    include ADMIN_TEMPLATES . 'layout.html.php';
}
