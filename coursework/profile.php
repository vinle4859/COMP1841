<?php
/**
 * User Profile Page
 * View and edit user's own profile
 */
include 'includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['auth' => true, 'csrf' => false]); // Manual CSRF for friendly error

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'UserDbFunctions.php';
include FUNCTIONS_PATH . 'AuthDbFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include FUNCTIONS_PATH . 'AnswerDbFunctions.php';

$error = '';
$success = '';
$userId = getCurrentUserId();

// Get user profile with stats
$profile = getUserProfile($pdo, $userId);

if (!$profile) {
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $action = $_POST['action'] ?? '';
        
        if ($action === 'update_profile') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            
            if (empty($username) || empty($email)) {
                $error = 'Username and email are required.';
            } elseif (strlen($username) < 3 || strlen($username) > 50) {
                $error = 'Username must be between 3 and 50 characters.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } else {
                $existingUser = getUserByUsername($pdo, $username);
                if ($existingUser && $existingUser['user_id'] != $userId) {
                    $error = 'This username is already taken.';
                } else {
                    $existingEmail = getUserByEmail($pdo, $email);
                    if ($existingEmail && $existingEmail['user_id'] != $userId) {
                        $error = 'This email is already in use.';
                    } else {
                        updateUser($pdo, $userId, $username, $email);
                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $email;
                        $success = 'Profile updated successfully.';
                        $profile = getUserProfile($pdo, $userId);
                    }
                }
            }
        } elseif ($action === 'change_password') {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                $error = 'All password fields are required.';
            } elseif (strlen($newPassword) < 6) {
                $error = 'New password must be at least 6 characters.';
            } elseif ($newPassword !== $confirmPassword) {
                $error = 'New passwords do not match.';
            } elseif (!checkCurrentPassword($pdo, $userId, $currentPassword)) {
                $error = 'Current password is incorrect.';
            } else {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                updateUserPassword($pdo, $userId, $hashedPassword);
                $success = 'Password changed successfully.';
            }
        } elseif ($action === 'delete_account') {
            // Prevent admin from deleting their own account
            if (isAdmin()) {
                $error = 'Admin accounts cannot be deleted through the profile page.';
            } else {
                $confirmDelete = $_POST['confirm_delete'] ?? '';
                $password = $_POST['delete_password'] ?? '';
                
                if ($confirmDelete !== 'DELETE') {
                    $error = 'Please type DELETE to confirm account deletion.';
                } elseif (!checkCurrentPassword($pdo, $userId, $password)) {
                    $error = 'Password is incorrect.';
                } else {
                    deleteUser($pdo, $userId);
                    logoutUser();
                    header('Location: ' . BASE_URL . '/index.php?deleted=1');
                    exit;
                }
            }
        }
    }
}

// Get user's recent activity
$myQuestions = getQuestionList($pdo, null, $userId, true);
$myQuestions = array_slice($myQuestions, 0, 5);
$myAnswers = getAnswersByUser($pdo, $userId, 5);

// Render page
$title = 'My Profile - Student Forum';
$activePage = 'profile';
ob_start();
include PUBLIC_TEMPLATES . 'profile.html.php';
$output = ob_get_clean();
include PUBLIC_TEMPLATES . 'layout.html.php';
