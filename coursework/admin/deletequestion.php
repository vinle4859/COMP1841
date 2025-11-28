<?php
include '../includes/config.php';
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
}

if (!empty($output)) {
    include ADMIN_TEMPLATES . 'layout.html.php';
}
?>
