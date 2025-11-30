<?php
/**
 * Public: Delete own answer
 * POST-only action - users can only delete answers they created
 */
include 'includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'AnswerDbFunctions.php';

// Initialize request: require login, CSRF validated automatically for POST
initRequest(['auth' => true]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer_id'])) {
    $answer_id = intval($_POST['answer_id']);
    
    try {
        $answer = getAnswer($pdo, $answer_id);
        
        if (!$answer) {
            header('Location: questions.php');
            exit;
        }
        
        // Check ownership - user can only delete their own answers
        if ($answer['user_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASE_URL . '/auth/unauthorized.php');
            exit;
        }
        
        deleteAnswer($pdo, $answer_id);
        header('Location: questiondetail.php?id=' . $answer['question_id']);
        exit;
        
    } catch (PDOException $e) {
        $title = 'An error has occurred';
        $output = 'Unable to delete answer: ' . $e->getMessage();
        include PUBLIC_TEMPLATES . 'layout.html.php';
        exit;
    }
}

header('Location: questions.php');
exit;
