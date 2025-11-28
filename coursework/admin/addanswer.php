<?php
// Handler for adding answers from admin question detail page
include '../includes/config.php';
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
$userId = intval($_POST['user_id'] ?? 0);

if ($answerContent === '') {
    header('Location: ' . $redirectUrl . '&error=' . urlencode('Please enter your answer.'));
    exit;
}

if ($userId <= 0) {
    header('Location: ' . $redirectUrl . '&error=' . urlencode('Please select a user.'));
    exit;
}

$image = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $allowed = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = $_FILES['image']['type'];
    
    if (in_array($fileType, $allowed) && $_FILES['image']['size'] <= 2 * 1024 * 1024) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newName = 'answer_' . time() . '_' . uniqid() . '.' . $ext;
        $destination = IMAGES_PATH . $newName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
            $image = $newName;
        }
    } else {
        header('Location: ' . $redirectUrl . '&error=' . urlencode('Invalid image. Allowed: JPG, PNG, GIF. Max 2MB.'));
        exit;
    }
}

try {
    addAnswer($pdo, $questionId, $answerContent, $userId, $image);
    header('Location: ' . $redirectUrl . '&success=' . urlencode('Answer has been posted!'));
    exit;
} catch (PDOException $e) {
    header('Location: ' . $redirectUrl . '&error=' . urlencode('Failed to post answer.'));
    exit;
}
