<?php
/**
 * Accept/Unaccept Answer Handler
 * Only the question owner can accept an answer
 */
include 'includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['auth' => true, 'csrf' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include FUNCTIONS_PATH . 'AnswerDbFunctions.php';

// Must be POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: questions.php');
    exit;
}

$answer_id = intval($_POST['answer_id'] ?? 0);
$question_id = intval($_POST['question_id'] ?? 0);
$action = $_POST['action'] ?? 'accept';

if ($answer_id <= 0 || $question_id <= 0) {
    header('Location: questions.php');
    exit;
}

// Get the question to verify ownership
$question = getQuestion($pdo, $question_id);
if (!$question || $question['user_id'] !== getCurrentUserId()) {
    header('Location: questiondetail.php?id=' . $question_id . '&error=' . urlencode('Only the question author can accept answers.'));
    exit;
}

// Get the answer to verify it belongs to this question
$answer = getAnswer($pdo, $answer_id);
if (!$answer || $answer['question_id'] !== $question_id) {
    header('Location: questiondetail.php?id=' . $question_id);
    exit;
}

// Accept or unaccept
if ($action === 'unaccept') {
    unacceptAnswer($pdo, $answer_id);
} else {
    acceptAnswer($pdo, $answer_id, $question_id);
}

header('Location: questiondetail.php?id=' . $question_id);
exit;
