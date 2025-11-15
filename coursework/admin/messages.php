<?php
// Admin inbox (moved into admin/)
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';

$messages = getMessageList($pdo);
$title = 'Admin Inbox';
ob_start();
include '../templates/admin_messages.html.php';
$output = ob_get_clean();
include '../templates/admin_layout.html.php';

