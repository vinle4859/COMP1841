<?php
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'MessageDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

$message_id = get_or_redirect('id', 'messages.php');

// Mark as read if currently 'new'
$message = getContactMessage($pdo, $message_id);
if ($message && $message['status'] === 'new') {
    setMessageStatus($pdo, $message_id, 'read');
    $message['status'] = 'read'; // Update local copy
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $newStatus = trim($_POST['status'] ?? '');
        if ($newStatus !== '') {
            setMessageStatus($pdo, $message_id, $newStatus);
            header('Location: messages.php');
            exit;
        }
    }
}

$title = 'Message';
ob_start();
include ADMIN_TEMPLATES . 'messagedetail.html.php';
$output = ob_get_clean();
include ADMIN_TEMPLATES . 'layout.html.php';
