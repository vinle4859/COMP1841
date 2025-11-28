<?php
// Admin: Edit an existing answer
include '../includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'AnswerDbFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

$error = null;
$answer_id = get_or_redirect('id', 'questions.php');

$answer = getAnswer($pdo, $answer_id);
if (!$answer) {
    header('Location: questions.php');
    exit;
}

$question = getQuestion($pdo, $answer['question_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content'] ?? '');
    
    if ($content === '') {
        $error = 'Answer content is required.';
    } else {
        $image = $answer['image'];
        
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
                $error = 'Invalid image. Allowed: JPG, PNG, GIF. Max 2MB.';
            }
        }
        
        if (!$error) {
            updateAnswer($pdo, $answer_id, $content, $image);
            header('Location: questiondetail.php?id=' . $answer['question_id']);
            exit;
        }
    }
} else {
    $content = $answer['content'];
}

$title = 'Edit Answer';
$activePage = 'questions';

ob_start();
include ADMIN_TEMPLATES . 'editanswer.html.php';
$output = ob_get_clean();
include ADMIN_TEMPLATES . 'layout.html.php';
