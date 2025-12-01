<?php
/**
 * Admin - Edit Answer
 * Modify any answer's content or image.
 */
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'AnswerDbFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

$error = null;
$answer_id = get_or_redirect('id', 'questions.php');

$answer = getAnswer($pdo, $answer_id);
if (!$answer) {
    header('Location: questions.php');
    exit;
}

$question = getQuestion($pdo, $answer['question_id']);

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $content = trim($_POST['content'] ?? '');
        
        if ($content === '') {
            $error = 'Answer content is required.';
        } else {
            $image = $answer['image'];
            
            // Handle image upload
            $upload = handleImageUpload('image', 'answer_');
            if (!$upload['success']) {
                $error = $upload['error'];
            } elseif ($upload['filename']) {
                $image = $upload['filename'];
            }
            
            if (!$error) {
                updateAnswer($pdo, $answer_id, $content, $image);
                header('Location: questiondetail.php?id=' . $answer['question_id']);
                exit;
            }
        }
    }
} else {
    $content = $answer['content'];
}

// Render page
$title = 'Edit Answer';
$activePage = 'questions';
ob_start();
include ADMIN_TEMPLATES . 'editanswer.html.php';
$output = ob_get_clean();
include ADMIN_TEMPLATES . 'layout.html.php';
