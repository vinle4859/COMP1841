<?php
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
include '../includes/InputHelpers.php';


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
include '../templates/admin_messagedetail.html.php';
$output = ob_get_clean();
include '../templates/admin_layout.html.php';
