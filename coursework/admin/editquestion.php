<?php
/**
 * Admin - Edit Question
 * Modify any question's title, content, image, module, or author.
 */
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include FUNCTIONS_PATH . 'UserDbFunctions.php';
include FUNCTIONS_PATH . 'ModuleDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

$error = null;

// Get question ID from POST or GET
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_id = (int) post_or_redirect('question_id', 'questions.php');
} else {
    $question_id = (int) get_or_redirect('id', 'questions.php');
}

$question = getQuestion($pdo, $question_id);
if (!$question) {
    header('Location: questions.php');
    exit;
}

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $content = trim($_POST['content'] ?? '');
        $titleInput = trim($_POST['title'] ?? '');
        $user = trim($_POST['user'] ?? '');
        $module = trim($_POST['module'] ?? '');
        
$uploadResult = handleImageUpload('image', 'question_');
        
        if (!$uploadResult['success']) {
            $error = $uploadResult['error'];
            $question['title'] = $titleInput;
            $question['content'] = $content;
            $question['user_id'] = $user;
            $question['module_id'] = $module;
        } elseif ($titleInput === '' || $content === '' || $user === '' || $module === '') {
            $error = 'Please provide title, content, user and module.';
            $question['title'] = $titleInput;
            $question['content'] = $content;
            $question['user_id'] = $user;
            $question['module_id'] = $module;
        } else {
            try {
                $final_image = $uploadResult['filename'] ?? $question['image'];
                updateQuestion($pdo, $question_id, $content, $titleInput, $final_image, $user, $module);
                header('Location: questions.php');
                exit;
            } catch (PDOException $e) {
                $error = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

// Render page
$title = 'Edit question';
$users = selectAll($pdo, 'user_account', true);
$modules = selectAll($pdo, 'module', true);
$current_user = getUser($pdo, $question['user_id']);
$current_module = getModule($pdo, $question['module_id']);

ob_start();
include ADMIN_TEMPLATES . 'editquestion.html.php';
$output = ob_get_clean();
include ADMIN_TEMPLATES . 'layout.html.php';
