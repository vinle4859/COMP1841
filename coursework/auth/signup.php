<?php
/**
 * Signup Page
 * Handles new user registration.
 */

require_once dirname(__DIR__) . '/includes/config.php';
require_once FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['csrf' => false]); // Manual CSRF for friendly error

require_once INCLUDES_PATH . 'DatabaseConnection.php';
require_once FUNCTIONS_PATH . 'DatabaseFunctions.php';
require_once FUNCTIONS_PATH . 'UserDbFunctions.php';
require_once FUNCTIONS_PATH . 'AuthDbFunctions.php';

// Already logged in? Redirect
if (isLoggedIn()) {
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

$error = '';
$success = '';

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if (empty($username) || empty($email) || empty($password)) {
            $error = 'All fields are required.';
        } elseif (strlen($username) < 3 || strlen($username) > 50) {
            $error = 'Username must be between 3 and 50 characters.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif ($password !== $confirmPassword) {
            $error = 'Passwords do not match.';
        } elseif (usernameExists($pdo, $username)) {
            $error = 'This username is already taken.';
        } elseif (emailExists($pdo, $email)) {
            $error = 'An account with this email already exists.';
        } else {
            try {
                $userId = registerUser($pdo, $username, $email, $password);
                $user = getUser($pdo, $userId);
                
                // Get redirect before login (which may regenerate session)
                $redirect = getRedirectAfterLogin();
                
                loginUser($user, false);
                setFlashMessage('success', 'Welcome! Your account has been created successfully.');
                
                if ($redirect) {
                    header('Location: ' . BASE_URL . $redirect);
                } else {
                    header('Location: ' . BASE_URL . '/index.php');
                }
                exit;
            } catch (PDOException $e) {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}

// Render page
$title = 'Sign Up - Student Forum';
$activePage = 'signup';
ob_start();
include PUBLIC_TEMPLATES . 'signup.html.php';
$output = ob_get_clean();
include PUBLIC_TEMPLATES . 'layout.html.php';
