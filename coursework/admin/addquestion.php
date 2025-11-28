<?php
include '../includes/DatabaseFunctions.php';
include '../includes/InputHelpers.php';
include '../includes/DatabaseConnection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $content = trim($_POST['content'] ?? '');
        $titleInput = trim($_POST['title'] ?? '');
        $user = trim($_POST['user'] ?? '');
        $module = trim($_POST['module'] ?? '');
        
        // Validate required fields FIRST
        if ($content === '' || $titleInput === '' || $module === '') {
            $error = 'Please enter the question title, content, and select a module.';
            $title = 'Add new question';
            $users = selectAll($pdo, "user_account");
            $modules = selectAll($pdo, "module");
            ob_start();
            include '../templates/addquestion.html.php';
            $output = ob_get_clean();
        } else {
            // Handle optional image upload
            $imageFilename = null;
            $uploadResult = handleImageUpload('image', '../images/');
            
            if (!$uploadResult['success']) {
                // Image upload failed (but image is optional, so show error but allow retry)
                $error = 'Image upload failed: ' . $uploadResult['error'];
                $title = 'Add new question';
                $users = selectAll($pdo, "user_account");
                $modules = selectAll($pdo, "module");
                ob_start();
                include '../templates/addquestion.html.php';
                $output = ob_get_clean();
            } else {
                // Success - image uploaded or no image provided
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
    include '../templates/addquestion.html.php';
    $output = ob_get_clean();
}

include '../templates/admin_layout.html.php';
?>
