<?php
/**
 * Handler for adding answers from public question detail page
 * POST-only action controller - redirects back to question detail
 */
include 'includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include INCLUDES_PATH . 'InputHelpers.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'AnswerDbFunctions.php';

// Initialize request: require login, CSRF validated automatically for POST
initRequest(['auth' => true]);

// Must have question_id
if (!isset($_POST['question_id']) || !is_numeric($_POST['question_id'])) {
    header('Location: questions.php');
    exit;
}

$questionId = (int) $_POST['question_id'];
$redirectUrl = 'questiondetail.php?id=' . $questionId;

// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $redirectUrl);
    exit;
}

$answerContent = trim($_POST['answer_content'] ?? '');
$userId = intval($_POST['user_id'] ?? 0);

// Validation
if ($answerContent === '') {
    header('Location: ' . $redirectUrl . '&error=' . urlencode('Please enter your answer.'));
    exit;
}

if ($userId <= 0) {
    header('Location: ' . $redirectUrl . '&error=' . urlencode('Please select your name.'));
    exit;
}

// Handle image upload
$upload = handleImageUpload('image', 'answer_');
if (!$upload['success']) {
    header('Location: ' . $redirectUrl . '&error=' . urlencode($upload['error']));
    exit;
}
$image = $upload['filename'];

// Add the answer
try {
    addAnswer($pdo, $questionId, $answerContent, $userId, $image);
    header('Location: ' . $redirectUrl . '&success=' . urlencode('Your answer has been posted!'));
    exit;
} catch (PDOException $e) {
    header('Location: ' . $redirectUrl . '&error=' . urlencode('Failed to post answer.'));
    exit;
}
