<?php
/**
 * Login Page
 * Handles user authentication for both public users and admins.
 * Includes rate limiting to prevent brute force attacks.
 */

require_once dirname(__DIR__) . '/includes/config.php';
require_once FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['csrf' => false]); // Manual CSRF for friendly error

require_once INCLUDES_PATH . 'DatabaseConnection.php';
require_once FUNCTIONS_PATH . 'DatabaseFunctions.php';
require_once FUNCTIONS_PATH . 'AuthDbFunctions.php';

// Already logged in? Redirect appropriately
if (isLoggedIn()) {
    $redirect = isAdmin() ? '/admin/questions.php' : '/index.php';
    header('Location: ' . BASE_URL . $redirect);
    exit;
}

$error = '';

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        $error = 'Invalid security token. Please try again.';
    } elseif (isRateLimited()) {
        $remaining = getRemainingLockoutTime();
        $minutes = ceil($remaining / 60);
        $error = "Too many failed attempts. Please try again in {$minutes} minute(s).";
    } else {
        $login = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($login) || empty($password)) {
            $error = 'Please enter your username/email and password.';
        } else {
            $user = verifyCredentials($pdo, $login, $password);
            
            if ($user) {
                clearLoginAttempts();
                $isAdmin = isUserAdmin($pdo, $user['user_id']);
                
                // Get redirect URL BEFORE loginUser() regenerates session
                $redirect = getRedirectAfterLogin();
                
                loginUser($user, $isAdmin);
                
                if ($redirect) {
                    // Redirect is stored relative to BASE_URL
                    header('Location: ' . BASE_URL . $redirect);
                } elseif ($isAdmin) {
                    header('Location: ' . BASE_URL . '/admin/questions.php');
                } else {
                    header('Location: ' . BASE_URL . '/index.php');
                }
                exit;
            } else {
                recordFailedAttempt();
                $attemptsLeft = 5 - ($_SESSION['login_attempts'] ?? 0);
                if ($attemptsLeft > 0) {
                    $error = "Invalid username/email or password. {$attemptsLeft} attempt(s) remaining.";
                } else {
                    $error = "Too many failed attempts. Please try again in 15 minutes.";
                }
            }
        }
    }
}

// Render page
$title = 'Login - Student Forum';
$activePage = 'login';
ob_start();
include PUBLIC_TEMPLATES . 'login.html.php';
$output = ob_get_clean();
include PUBLIC_TEMPLATES . 'layout.html.php';
