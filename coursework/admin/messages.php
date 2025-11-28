<?php
// Admin inbox
include '../includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'MessageDbFunctions.php';

$messages = getMessageList($pdo);
$title = 'Admin Inbox';
$activePage = 'messages';
ob_start();
include ADMIN_TEMPLATES . 'messages.html.php';
$output = ob_get_clean();
include ADMIN_TEMPLATES . 'layout.html.php';

