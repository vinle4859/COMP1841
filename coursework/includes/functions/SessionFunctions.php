<?php
/**
 * Session Management Functions
 * Handles session operations, login state, and access control.
 */

/**
 * Initialize session if not already started
 */
function initSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    initSession();
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Check if current user is an administrator
 */
function isAdmin() {
    initSession();
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

/**
 * Get current logged-in user ID
 */
function getCurrentUserId() {
    initSession();
    return $_SESSION['user_id'] ?? null;
}

/**
 * Log in a user - set session variables
 */
function loginUser($user, $isAdmin = false) {
    initSession();
    
    // Regenerate session ID for security
    session_regenerate_id(true);
    
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['is_admin'] = $isAdmin;
    $_SESSION['login_time'] = time();
}

/**
 * Log out the current user
 */
function logoutUser() {
    initSession();
    
    // Clear all session variables
    $_SESSION = [];
    
    // Delete the session cookie
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
    
    // Destroy the session
    session_destroy();
}

/**
 * Require user to be logged in
 * Redirects to login page if not authenticated
 * Auto-saves current URL for redirect after login
 */
function requireLogin() {
    if (!isLoggedIn()) {
        initSession();
        // Store the intended destination relative to BASE_URL for portability
        $currentUrl = $_SERVER['REQUEST_URI'] ?? '';
        // Strip BASE_URL prefix to make it portable
        if (!empty($currentUrl) && strpos($currentUrl, '/auth/') === false) {
            $relativeUrl = $currentUrl;
            if (strpos($currentUrl, BASE_URL) === 0) {
                $relativeUrl = substr($currentUrl, strlen(BASE_URL));
            }
            $_SESSION['redirect_after_login'] = $relativeUrl;
        }
        header('Location: ' . BASE_URL . '/auth/login.php');
        exit;
    }
}

/**
 * Require user to be an administrator
 * Redirects to unauthorized page if not admin
 */
function requireAdmin() {
    requireLogin();
    
    if (!isAdmin()) {
        header('Location: ' . BASE_URL . '/auth/unauthorized.php');
        exit;
    }
}

/**
 * Get and clear redirect URL after login
 * Falls back to last_page if no explicit redirect was set
 */
function getRedirectAfterLogin() {
    initSession();
    // First check explicit redirect (from requireLogin or URL param)
    $redirect = $_SESSION['redirect_after_login'] ?? null;
    unset($_SESSION['redirect_after_login']);
    
    // Fall back to last visited page
    if (!$redirect) {
        $redirect = $_SESSION['last_page'] ?? null;
    }
    unset($_SESSION['last_page']);
    
    return $redirect;
}

/**
 * Set a flash message to display on next page
 */
function setFlashMessage($type, $message) {
    initSession();
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Get and clear flash message
 */
function getFlashMessage() {
    initSession();
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

/**
 * Generate a CSRF token and store it in session
 */
function generateCsrfToken() {
    initSession();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Get the current CSRF token (generates one if not exists)
 */
function getCsrfToken() {
    return generateCsrfToken();
}

/**
 * Output a hidden CSRF token input field for forms
 */
function csrfField() {
    $token = getCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
}

/**
 * Validate CSRF token from POST request
 * Returns true if valid, false otherwise
 */
function validateCsrfToken() {
    initSession();
    if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}

/**
 * Require valid CSRF token or die with error
 */
function requireCsrfToken() {
    if (!validateCsrfToken()) {
        http_response_code(403);
        die('Invalid security token. Please go back and try again.');
    }
}

/**
 * Initialize a request with common security checks.
 * This is a simple "middleware-like" pattern that centralizes:
 * - Session initialization
 * - CSRF validation for POST requests
 * - Authentication checks
 * - Admin authorization checks
 * 
 * @param array $options Configuration options:
 *   - 'auth' => bool: Require logged-in user (default: false)
 *   - 'admin' => bool: Require admin user (default: false)  
 *   - 'csrf' => bool: Validate CSRF on POST (default: true)
 * @return void
 */
function initRequest($options = []) {
    $requireAuth = $options['auth'] ?? false;
    $requireAdmin = $options['admin'] ?? false;
    $validateCsrf = $options['csrf'] ?? true;
    
    // Always start session
    initSession();
    
    // Track last visited page for redirect after login (Option 4)
    // Only save non-auth pages, and only for GET requests
    $currentUrl = $_SERVER['REQUEST_URI'] ?? '';
    if ($_SERVER['REQUEST_METHOD'] === 'GET' 
        && strpos($currentUrl, '/auth/') === false 
        && !empty($currentUrl)) {
        // Strip BASE_URL for portability
        $relativePath = $currentUrl;
        if (strpos($currentUrl, BASE_URL) === 0) {
            $relativePath = substr($currentUrl, strlen(BASE_URL));
        }
        $_SESSION['last_page'] = $relativePath;
    }
    
    // CSRF protection for all POST/PUT/DELETE requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $validateCsrf) {
        requireCsrfToken();
    }
    
    // Authentication check - use requireLogin() to save redirect URL
    if ($requireAuth && !isLoggedIn()) {
        requireLogin();
    }
    
    // Admin authorization check - use requireLogin() to save redirect URL
    if ($requireAdmin) {
        if (!isLoggedIn()) {
            requireLogin();
        }
        if (!isAdmin()) {
            header('Location: ' . BASE_URL . '/auth/unauthorized.php');
            exit;
        }
    }
}
