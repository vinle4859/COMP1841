<?php
// Simple admin inbox view (no auth in current project)
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';

$messages = getMessages($pdo);
$title = 'Admin Inbox';
ob_start();
include 'templates/admin_messages.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
