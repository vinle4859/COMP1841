<?php
// Admin: Edit an existing answer
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
include '../includes/InputHelpers.php';

$error = null;
$answer_id = get_or_redirect('id', 'questions.php');

// Get the answer
$answer = getAnswer($pdo, $answer_id);
if (!$answer) {
    header('Location: questions.php');
    exit;
}

// Get the question for context and redirect
$question = getQuestion($pdo, $answer['question_id']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content'] ?? '');
    
    if ($content === '') {
        $error = 'Answer content is required.';
    } else {
        // Handle image upload if provided
        $image = $answer['image']; // Keep existing image by default
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = $_FILES['image']['type'];
            
            if (in_array($fileType, $allowed) && $_FILES['image']['size'] <= 2 * 1024 * 1024) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $newName = 'answer_' . time() . '_' . uniqid() . '.' . $ext;
                $destination = '../images/' . $newName;
                
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
include '../templates/editanswer.html.php';
$output = ob_get_clean();
include '../templates/admin_layout.html.php';
