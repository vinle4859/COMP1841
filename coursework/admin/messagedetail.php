<?php
include '../includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'MessageDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

$message_id = get_or_redirect('id', 'messages.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newStatus = trim($_POST['status'] ?? '');
    if ($newStatus !== '') {
        setMessageStatus($pdo, $message_id, $newStatus);
        header('Location: messages.php');
        exit;
    }
}

$message = getContactMessage($pdo, $message_id);
$title = 'Message';
ob_start();
include ADMIN_TEMPLATES . 'messagedetail.html.php';
$output = ob_get_clean();
include ADMIN_TEMPLATES . 'layout.html.php';
