<?php
// Admin: Delete an answer
include '../includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'AnswerDbFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer_id'])) {
    $answer_id = intval($_POST['answer_id']);
    $question_id = intval($_POST['question_id'] ?? 0);
    
    $answer = getAnswer($pdo, $answer_id);
    if ($answer) {
        $question_id = $answer['question_id'];
        deleteAnswer($pdo, $answer_id);
    }
    
    if ($question_id > 0) {
        header('Location: questiondetail.php?id=' . $question_id);
    } else {
        header('Location: questions.php');
    }
    exit;
}

header('Location: questions.php');
exit;
