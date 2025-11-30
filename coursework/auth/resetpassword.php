<?php
/**
 * Reset Password Page
 * Allows users to set a new password using a valid reset token.
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
$tokenValid = false;
$token = $_GET['token'] ?? $_POST['token'] ?? '';

// Verify token
if (!empty($token)) {
    $email = verifyResetToken($pdo, $token);
    $tokenValid = $email ? true : false;
    if (!$tokenValid) {
        $error = 'Invalid or expired reset link. Please request a new one.';
    }
} else {
    $error = 'No reset token provided. Please use the link from your email.';
}

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $tokenValid) {
    if (!validateCsrfToken()) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if (empty($password)) {
            $error = 'Please enter a new password.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters long.';
        } elseif ($password !== $confirmPassword) {
            $error = 'Passwords do not match.';
        } else {
            resetPasswordByEmail($pdo, $email, $password);
            deleteResetToken($pdo, $email);
            $success = 'Your password has been reset successfully! You can now log in with your new password.';
            $tokenValid = false; // Hide the form
        }
    }
}

// Render page
$title = 'Reset Password - Student Forum';
$activePage = 'login';
ob_start();
include PUBLIC_TEMPLATES . 'resetpassword.html.php';
$output = ob_get_clean();
include PUBLIC_TEMPLATES . 'layout.html.php';
