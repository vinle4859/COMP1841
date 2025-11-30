<?php
// Handler for adding answers from admin question detail page
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true, 'csrf' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'AnswerDbFunctions.php';

if (!isset($_POST['question_id']) || !is_numeric($_POST['question_id'])) {
    header('Location: questions.php');
    exit;
}

$questionId = (int) $_POST['question_id'];
$redirectUrl = 'questiondetail.php?id=' . $questionId;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $redirectUrl);
    exit;
}

$answerContent = trim($_POST['answer_content'] ?? '');
$userId = getCurrentUserId(); // Admin posts as themselves

if ($answerContent === '') {
    header('Location: ' . $redirectUrl . '&error=' . urlencode('Please enter your answer.'));
    exit;
}

// Handle image upload
$upload = handleImageUpload('image', 'answer_');
if (!$upload['success']) {
    header('Location: ' . $redirectUrl . '&error=' . urlencode($upload['error']));
    exit;
}
$image = $upload['filename'];

try {
    addAnswer($pdo, $questionId, $answerContent, $userId, $image);
    header('Location: ' . $redirectUrl . '&success=' . urlencode('Answer has been posted!'));
    exit;
} catch (PDOException $e) {
    header('Location: ' . $redirectUrl . '&error=' . urlencode('Failed to post answer.'));
    exit;
}
