<?php
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: admin_messages.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $newStatus = $_POST['status'];
    setMessageStatus($pdo, $id, $newStatus);
}

$message = getMessageById($pdo, $id);
if (!$message) {
    header('Location: admin_messages.php');
    exit;
}

$title = 'Message #' . $id;
ob_start();
include 'templates/admin_message.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
