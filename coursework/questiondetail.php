<?php
/**
 * Question Detail Page
 * Displays question with answers, tracks view count (once per session).
 */
include 'includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(); // Track last_page for redirect after login

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
    
    // Track view count (once per session per question)
    $viewedKey = 'viewed_questions';
    if (!isset($_SESSION[$viewedKey])) {
        $_SESSION[$viewedKey] = [];
    }
    if (!in_array($id, $_SESSION[$viewedKey])) {
        incrementViewCount($pdo, $id);
        $_SESSION[$viewedKey][] = $id;
    }
    
    // Use DatabaseFunctions helper to load question and answers (public view)
    $detail = getQuestionDetail($pdo, $id, true);
    $question = $detail['question'];
    $answers = $detail['answers'];

    // Render the detail template into $output so layout can place it in the page
    // Set a sensible page title first (explicit if/else for clarity)
    if (isset($question['title']) && $question['title'] !== '') {
        $title = $question['title'];
    } else {
        $title = 'Question detail';
    }
    $activePage = 'questions';
    ob_start();
    include PUBLIC_TEMPLATES . 'questiondetail.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
    $question = null;
    $answers = [];
}
include PUBLIC_TEMPLATES . 'layout.html.php';
?>
