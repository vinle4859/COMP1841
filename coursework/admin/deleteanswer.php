<?php
// Admin: Delete an answer
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer_id'])) {
    $answer_id = intval($_POST['answer_id']);
    $question_id = intval($_POST['question_id'] ?? 0);
    
    // Verify the answer exists before deleting
    $answer = getAnswer($pdo, $answer_id);
    if ($answer) {
        $question_id = $answer['question_id']; // Use actual question_id from answer
        deleteAnswer($pdo, $answer_id);
    }
    
    // Redirect back to the question detail
    if ($question_id > 0) {
        header('Location: questiondetail.php?id=' . $question_id);
    } else {
        header('Location: questions.php');
    }
    exit;
}

// If not POST, redirect to questions list
header('Location: questions.php');
exit;
