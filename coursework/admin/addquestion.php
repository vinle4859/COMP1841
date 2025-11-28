<?php
include '../includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $content = trim($_POST['content'] ?? '');
        $titleInput = trim($_POST['title'] ?? '');
        $user = trim($_POST['user'] ?? '');
        $module = trim($_POST['module'] ?? '');
        
        if ($content === '' || $titleInput === '' || $module === '') {
            $error = 'Please enter the question title, content, and select a module.';
            $title = 'Add new question';
            $users = selectAll($pdo, "user_account");
            $modules = selectAll($pdo, "module");
            ob_start();
            include PUBLIC_TEMPLATES . 'addquestion.html.php';
            $output = ob_get_clean();
        } else {
            $imageFilename = null;
            $uploadResult = handleImageUpload('image', IMAGES_PATH);
            
            if (!$uploadResult['success']) {
                $error = 'Image upload failed: ' . $uploadResult['error'];
                $title = 'Add new question';
                $users = selectAll($pdo, "user_account");
                $modules = selectAll($pdo, "module");
                ob_start();
                include PUBLIC_TEMPLATES . 'addquestion.html.php';
                $output = ob_get_clean();
            } else {
                $imageFilename = $uploadResult['filename'];
                addQuestion($pdo, $content, $imageFilename, $titleInput, $user, $module);
                header('location: questions.php');
                exit;
            }
        }
    } catch (PDOException $e) {
        $title = 'An error has occured';
        $output = 'Database error: ' . $e->getMessage();
    }
} else {
    $title = 'Add new question';
    $users = selectAll($pdo, "user_account");
    $modules = selectAll($pdo, "module");
    ob_start();
    include PUBLIC_TEMPLATES . 'addquestion.html.php';
    $output = ob_get_clean();
}

include ADMIN_TEMPLATES . 'layout.html.php';
?>
