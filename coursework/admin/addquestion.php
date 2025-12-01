<?php
/**
 * Admin - Add Question
 * Create a new question on behalf of any user.
 */
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

$error = null;

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $content = trim($_POST['content'] ?? '');
        $titleInput = trim($_POST['title'] ?? '');
        $user = trim($_POST['user'] ?? '');
        $module = trim($_POST['module'] ?? '');
        
        if ($content === '' || $titleInput === '' || $module === '') {
            $error = 'Please enter the question title, content, and select a module.';
        } else {
$uploadResult = handleImageUpload('image', 'question_');
            
            if (!$uploadResult['success']) {
                $error = $uploadResult['error'];
            } else {
                try {
                    $imageFilename = $uploadResult['filename'];
                    addQuestion($pdo, $content, $imageFilename, $titleInput, $user, $module);
                    header('location: questions.php');
                    exit;
                } catch (PDOException $e) {
                    $error = 'Database error: ' . $e->getMessage();
                }
            }
        }
    }
}

// Render page
$title = 'Add new question';
$users = selectAll($pdo, "user_account");
$modules = selectAll($pdo, "module");
ob_start();
include PUBLIC_TEMPLATES . 'addquestion.html.php';
$output = ob_get_clean();
include ADMIN_TEMPLATES . 'layout.html.php';
