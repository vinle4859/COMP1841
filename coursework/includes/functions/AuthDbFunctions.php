<?php
/**
 * Authentication Database Functions
 * Handles user authentication, registration, and password management.
 */

/**
 * Get user by email address
 */
function getUserByEmail($pdo, $email) {
    $sql = 'SELECT * FROM user_account WHERE email = :email';
    $stmt = query($pdo, $sql, [':email' => $email]);
    return $stmt->fetch();
}

/**
 * Get user by username
 */
function getUserByUsername($pdo, $username) {
    $sql = 'SELECT * FROM user_account WHERE username = :username';
    $stmt = query($pdo, $sql, [':username' => $username]);
    return $stmt->fetch();
}

/**
 * Check if user is an administrator
 */
function isUserAdmin($pdo, $user_id) {
    $sql = 'SELECT 1 FROM user_role ur
            JOIN role r ON ur.role_id = r.role_id
            WHERE ur.user_id = :user_id AND r.role_name = \'Administrator\'';
    $stmt = query($pdo, $sql, [':user_id' => $user_id]);
    return $stmt->fetch() !== false;
}

/**
 * Register a new user
 * Returns the new user ID on success, or throws exception on failure
 */
function registerUser($pdo, $username, $email, $password) {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user
    $sql = 'INSERT INTO user_account (username, email, password, status) 
            VALUES (:username, :email, :password, \'active\')';
    $params = [
        ':username' => $username,
        ':email' => $email,
        ':password' => $hashedPassword
    ];
    query($pdo, $sql, $params);
    $userId = $pdo->lastInsertId();
    
    // Assign default role (Student = 1)
    $sql = 'INSERT INTO user_role (user_id, role_id) VALUES (:user_id, 1)';
    query($pdo, $sql, [':user_id' => $userId]);
    
    return $userId;
}

/**
 * Verify user credentials
 * Returns user array on success, false on failure
 */
function verifyCredentials($pdo, $login, $password) {
    // Try to find user by email or username
    $sql = 'SELECT * FROM user_account WHERE (email = :login OR username = :login) AND status = \'active\'';
    $stmt = query($pdo, $sql, [':login' => $login]);
    $user = $stmt->fetch();
    
    if (!$user) {
        return false;
    }
    
    // Verify password
    if (!password_verify($password, $user['password'])) {
        return false;
    }
    
    return $user;
}

/**
 * Create password reset token
 */
function createPasswordResetToken($pdo, $email) {
    $token = bin2hex(random_bytes(32));
    
    // Delete any existing token for this email
    $sql = 'DELETE FROM password_reset WHERE email = :email';
    query($pdo, $sql, [':email' => $email]);
    
    // Insert new token - expires in 15 minutes
    $sql = 'INSERT INTO password_reset (email, token, expires_at) VALUES (:email, :token, DATE_ADD(NOW(), INTERVAL 15 MINUTE))';
    query($pdo, $sql, [':email' => $email, ':token' => $token]);
    
    return $token;
}

/**
 * Verify password reset token
 * Returns email if valid, false if invalid or expired
 */
function verifyResetToken($pdo, $token) {
    $sql = 'SELECT email FROM password_reset WHERE token = :token AND expires_at > NOW()';
    $stmt = query($pdo, $sql, [':token' => $token]);
    $result = $stmt->fetch();
    return $result ? $result['email'] : false;
}

/**
 * Delete password reset token
 */
function deleteResetToken($pdo, $email) {
    $sql = 'DELETE FROM password_reset WHERE email = :email';
    query($pdo, $sql, [':email' => $email]);
}

/**
 * Check if username already exists
 */
function usernameExists($pdo, $username) {
    $sql = 'SELECT 1 FROM user_account WHERE username = :username';
    $stmt = query($pdo, $sql, [':username' => $username]);
    return $stmt->fetch() !== false;
}

/**
 * Check if email already exists
 */
function emailExists($pdo, $email) {
    $sql = 'SELECT 1 FROM user_account WHERE email = :email';
    $stmt = query($pdo, $sql, [':email' => $email]);
    return $stmt->fetch() !== false;
}

/**
 * Reset password by email
 */
function resetPasswordByEmail($pdo, $email, $newPassword) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = 'UPDATE user_account SET password = :password WHERE email = :email';
    query($pdo, $sql, [':password' => $hashedPassword, ':email' => $email]);
}

// ============================================
// RATE LIMITING FUNCTIONS (Session-based)
// ============================================

/**
 * Check if login attempts exceeded (max 5 attempts per 15 minutes)
 */
function isRateLimited() {
    $maxAttempts = 5;
    $lockoutTime = 15 * 60; // 15 minutes in seconds
    
    if (!isset($_SESSION['login_attempts'])) {
        return false;
    }
    
    $attempts = $_SESSION['login_attempts'];
    $firstAttempt = $_SESSION['login_first_attempt'] ?? time();
    
    // Reset if lockout period has passed
    if (time() - $firstAttempt > $lockoutTime) {
        unset($_SESSION['login_attempts']);
        unset($_SESSION['login_first_attempt']);
        return false;
    }
    
    return $attempts >= $maxAttempts;
}

/**
 * Record a failed login attempt
 */
function recordFailedAttempt() {
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['login_first_attempt'] = time();
    }
    $_SESSION['login_attempts']++;
}

/**
 * Clear login attempts on successful login
 */
function clearLoginAttempts() {
    unset($_SESSION['login_attempts']);
    unset($_SESSION['login_first_attempt']);
}

/**
 * Get remaining lockout time in seconds
 */
function getRemainingLockoutTime() {
    if (!isset($_SESSION['login_first_attempt'])) {
        return 0;
    }
    $lockoutTime = 15 * 60;
    $elapsed = time() - $_SESSION['login_first_attempt'];
    return max(0, $lockoutTime - $elapsed);
}
