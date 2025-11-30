<?php
/**
 * Forgot Password Page
 * Generates a password reset token and displays the reset link.
 * Includes cooldown to prevent spam.
 */

require_once dirname(__DIR__) . '/includes/config.php';
require_once FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['csrf' => false]); // Manual CSRF for friendly error

require_once INCLUDES_PATH . 'DatabaseConnection.php';
require_once FUNCTIONS_PATH . 'DatabaseFunctions.php';
require_once FUNCTIONS_PATH . 'AuthDbFunctions.php';

// Already logged in? Redirect
if (isLoggedIn()) {
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

$error = '';
$success = '';
$resetLink = '';
$cooldownRemaining = 0;

// Check cooldown (60 seconds between requests)
$cooldownSeconds = 60;
if (isset($_SESSION['last_reset_request'])) {
    $elapsed = time() - $_SESSION['last_reset_request'];
    if ($elapsed < $cooldownSeconds) {
        $cooldownRemaining = $cooldownSeconds - $elapsed;
    }
}

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $email = trim($_POST['email'] ?? '');
        
        if ($cooldownRemaining > 0) {
            $error = "Please wait {$cooldownRemaining} seconds before requesting another reset email.";
        } elseif (empty($email)) {
            $error = 'Please enter your email address.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } else {
            if (emailExists($pdo, $email)) {
                $token = createPasswordResetToken($pdo, $email);
                $resetLink = BASE_URL . '/auth/resetpassword.php?token=' . $token;
                $_SESSION['last_reset_request'] = time();
                $success = 'Reset email generated! In future development, this would be sent to your email.';
            } else {
                $_SESSION['last_reset_request'] = time();
                $success = 'If an account with that email exists, a reset email has been generated.';
            }
        }
    }
}

// Render page
$title = 'Forgot Password - Student Forum';
$activePage = 'login';
$emailValue = $_POST['email'] ?? '';
ob_start();
include PUBLIC_TEMPLATES . 'forgotpassword.html.php';
$output = ob_get_clean();
include PUBLIC_TEMPLATES . 'layout.html.php';
