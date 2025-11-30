<?php
/**
 * Public: Edit own answer
 * Users can only edit answers they created
 */
include 'includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'AnswerDbFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

// Initialize request: require login, CSRF validated automatically for POST
initRequest(['auth' => true]);

$error = null;
$answer_id = (int) ($_GET['id'] ?? 0);

if ($answer_id <= 0) {
    header('Location: questions.php');
    exit;
}

$answer = getAnswer($pdo, $answer_id);
if (!$answer) {
    header('Location: questions.php');
    exit;
}

// Check ownership - user can only edit their own answers
if ($answer['user_id'] != $_SESSION['user_id']) {
    header('Location: ' . BASE_URL . '/auth/unauthorized.php');
    exit;
}

$question = getQuestion($pdo, $answer['question_id']);
$content = $answer['content'];

// Handle POST submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            // Success - redirect and exit
            updateAnswer($pdo, $answer_id, $content, $image);
            header('Location: questiondetail.php?id=' . $answer['question_id']);
            exit;
        }
    }
}

// Render page (for GET or failed POST)
$title = 'Edit Your Answer';
$activePage = 'questions';
ob_start();
include PUBLIC_TEMPLATES . 'editanswer.html.php';
$output = ob_get_clean();

include PUBLIC_TEMPLATES . 'layout.html.php';
