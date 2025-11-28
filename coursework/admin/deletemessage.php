<?php
try {
    include '../includes/DatabaseConnection.php';
    include '../includes/DatabaseFunctions.php';
    include '../includes/InputHelpers.php';
    $message_id = (int) post_or_redirect('message_id', 'messages.php');
    deleteMessage($pdo, $message_id);
    header('Location: messages.php');
    exit;
} catch (PDOException $e) {
    $title = "An error has occured";
    $output = 'Database error: ' . $e->getMessage();
}

if (!empty($output)) {
    include '../templates/admin_layout.html.php';
}
?>
