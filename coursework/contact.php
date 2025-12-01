<?php
/**
 * Contact Form Page
 * Submit messages to site admin. Pre-fills name/email for logged-in users.
 */
include 'includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['csrf' => false]); // Manual CSRF for friendly error

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'MessageDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

// Initialize form variables
$name = $email = $subject = $body = '';
$error = $success = '';

// Pre-fill from session if logged in
if (isLoggedIn()) {
    $name = $_SESSION['username'] ?? '';
    $email = $_SESSION['email'] ?? '';
}

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $body = trim($_POST['body'] ?? '');

        if ($name === '' || $email === '' || $subject === '' || $body === '') {
            $error = 'Please fill all required fields.';
        } else {
            try {
                $user_id = getCurrentUserId();
                addMessage($pdo, $subject, $body, $name, $email, $user_id);
                
                // Reset form and show success
                $name = $email = $subject = $body = '';
                if (isLoggedIn()) {
                    $name = $_SESSION['username'] ?? '';
                    $email = $_SESSION['email'] ?? '';
                }
                $success = 'Your message has been sent successfully.';
            } catch (PDOException $e) {
                $error = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

// Render page
$title = 'Contact';
$activePage = 'contact';
ob_start();
include PUBLIC_TEMPLATES . 'contact.html.php';
$output = ob_get_clean();
include PUBLIC_TEMPLATES . 'layout.html.php';
