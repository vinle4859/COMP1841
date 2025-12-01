<?php
/**
 * Admin - Inbox
 * View contact form submissions, mark as read/unread, delete messages.
 */
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'MessageDbFunctions.php';

// Filter by unread if requested
$showUnreadOnly = isset($_GET['unread']) && $_GET['unread'] === '1';
$messages = getMessageList($pdo, $showUnreadOnly ? 'new' : null);
$totalUnreadCount = getUnreadMessageCount($pdo);

$title = 'Admin Inbox';
$activePage = 'messages';
ob_start();
include ADMIN_TEMPLATES . 'messages.html.php';
$output = ob_get_clean();
include ADMIN_TEMPLATES . 'layout.html.php';

