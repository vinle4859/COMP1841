<?php
/**
 * Public: Edit own question
 * Users can only edit questions they created
 */
include 'includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include FUNCTIONS_PATH . 'ModuleDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

// Initialize request: require login, CSRF validated automatically for POST
initRequest(['auth' => true]);

$error = null;

try {
    // Get question ID from POST or GET
    $question_id = (int) ($_POST['question_id'] ?? $_GET['id'] ?? 0);
    if ($question_id <= 0) {
        header('Location: questions.php');
        exit;
    }
    
    $question = getQuestion($pdo, $question_id);
    
    if (!$question) {
        header('Location: questions.php');
        exit;
    }
    
    // Check ownership - user can only edit their own questions
    if ($question['user_id'] != $_SESSION['user_id']) {
        header('Location: ' . BASE_URL . '/auth/unauthorized.php');
        exit;
    }
    
    // Get module name for display (users cannot change module)
    $module = getModule($pdo, $question['module_id']);
    $moduleName = $module ? $module['module_name'] : 'Unknown';

    // Handle POST submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = trim($_POST['content'] ?? '');
        $titleInput = trim($_POST['title'] ?? '');
        
$uploadResult = handleImageUpload('image', 'question_');
        
        if (!$uploadResult['success']) {
            $error = $uploadResult['error'];
            $question['title'] = $titleInput;
            $question['content'] = $content;
        } elseif ($titleInput === '' || $content === '') {
            $error = 'Please provide title and content.';
            $question['title'] = $titleInput;
            $question['content'] = $content;
        } else {
            // Success - redirect and exit
            $final_image = $uploadResult['filename'] ?? $question['image'];
            updateQuestion($pdo, $question_id, $content, $titleInput, $final_image, $question['user_id'], $question['module_id']);
            header('Location: questiondetail.php?id=' . $question_id);
            exit;
        }
    }
    
    // Render page (for GET or failed POST)
    $title = 'Edit Your Question';
    $activePage = 'questions';
    ob_start();
    include PUBLIC_TEMPLATES . 'editquestion.html.php';
    $output = ob_get_clean();
    
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();
}

include PUBLIC_TEMPLATES . 'layout.html.php';
