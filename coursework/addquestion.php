<?php
/**
 * Add Question Page
 * Allows authenticated users to post new questions.
 */
include 'includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

// Initialize request: require login, CSRF validated automatically for POST
initRequest(['auth' => true]);

$error = null;

// Handle POST submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $content = trim($_POST['content'] ?? '');
        $titleInput = trim($_POST['title'] ?? '');
        $user = getCurrentUserId();
        $module = trim($_POST['module'] ?? '');

        if ($content === '' || $titleInput === '' || $module === '') {
            $error = 'Please provide a title, content and select a module.';
        } else {
            $uploadResult = handleImageUpload('image', 'question_');
            
            if (!$uploadResult['success']) {
                $error = $uploadResult['error'];
            } else {
                // Success - redirect and exit
                addQuestion($pdo, $content, $uploadResult['filename'], $titleInput, $user, $module);
                header('Location: questions.php');
                exit;
            }
        }
    } catch (PDOException $e) {
        $error = 'Database error: ' . $e->getMessage();
    }
}

// Render page (for GET or failed POST)
$title = 'Add new question';
$activePage = 'addquestion';
$modules = selectAll($pdo, "module");

ob_start();
include PUBLIC_TEMPLATES . 'addquestion.html.php';
$output = ob_get_clean();
include PUBLIC_TEMPLATES . 'layout.html.php';
