<?php
/**
 * Admin - Delete Question (POST handler)
 * Permanently removes question and all its answers (cascades).
 */
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true, 'csrf' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

try {
    $question_id = post_or_redirect('question_id', 'questions.php');
    deleteQuestion($pdo, $question_id);
    header('location: questions.php');
    exit;
} catch (PDOException $e) {
    $title = "An error has occured";
    $output = 'Unable to delete question: ' . $e->getMessage();
    include ADMIN_TEMPLATES . 'layout.html.php';
}
