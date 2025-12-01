<?php
/**
 * Admin - Question Detail
 * View question with all answers, add answers, delete question/answers.
 */
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include FUNCTIONS_PATH . 'AnswerDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

// Read messages from URL (set by addanswer.php after redirect)
$answerError = $_GET['error'] ?? '';
$answerSuccess = $_GET['success'] ?? '';

try {
    $id = get_or_redirect('id', 'questions.php');
    
    // Use the helper function
    $detail = getQuestionDetail($pdo, $id);
    $question = $detail['question'];
    $answers = $detail['answers'];
    
    // Get users list for answer dropdown
    $users = selectAll($pdo, 'user_account');

    // Render the detail template into $output so layout can place it in the page
    if (isset($question['title']) && $question['title'] !== '') {
        $title = $question['title'];
    } else {
        $title = 'Question detail';
    }
    $activePage = 'questions';
    ob_start();
    include ADMIN_TEMPLATES . 'questiondetail.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
    $question = null;
    $answers = [];
}
include ADMIN_TEMPLATES . 'layout.html.php';
?>
