<?php
include 'includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'MessageDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

// Initialize form variables to avoid undefined variable notices in the template
$name = $email = $subject = $body = '';
$error = $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $body = trim($_POST['body'] ?? '');

        if ($name === '' || $email === '' || $subject === '' || $body === '') {
            $error = 'Please fill all required fields.';
        } else {
            // no authentication, guest submission — store sender_name/sender_email
            $user_id = null;    
            addMessage($pdo, $subject, $body, $name, $email, $user_id);
            $name = $email = $subject = $body = '';
            $success = 'Your message has been sent successfully.';
        }
    } catch (PDOException $e) {
        $title = 'An error has occured';
        $output = 'Database error: ' . $e->getMessage();
    }
}

$title = 'Contact';
$activePage = 'contact';
ob_start();
include PUBLIC_TEMPLATES . 'contact.html.php';
$output = ob_get_clean();
include PUBLIC_TEMPLATES . 'layout.html.php';
