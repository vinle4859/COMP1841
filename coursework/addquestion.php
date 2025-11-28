<?php
include 'includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

if (isset($_POST['content'])) {
    try {
        // Read and trim inputs directly
        $content = trim($_POST['content'] ?? '');
        $titleInput = trim($_POST['title'] ?? '');
        // user and module are selections submitted as strings; read trimmed values
        $user = trim($_POST['user'] ?? '');
        $module = trim($_POST['module'] ?? '');

        // Validate required fields FIRST
        if ($content === '' || $titleInput === '' || $module === '') {
            $title = 'Add new question';
            $activePage = 'addquestion';
            $error = 'Please provide a title, content and select a module.';
            $users = selectAll($pdo, "user_account");
            $modules = selectAll($pdo, "module");
            ob_start();
            include PUBLIC_TEMPLATES . 'addquestion.html.php';
            $output = ob_get_clean();
        } else {
            // Handle optional image upload
            $imageFilename = null;
            $uploadResult = handleImageUpload('image', 'images/');
            
            if (!$uploadResult['success']) {
                // Image upload failed (but image is optional, so show error but allow retry)
                $error = 'Image upload failed: ' . $uploadResult['error'];
                $title = 'Add new question';
                $activePage = 'addquestion';
                $users = selectAll($pdo, "user_account");
                $modules = selectAll($pdo, "module");
                ob_start();
                include PUBLIC_TEMPLATES . 'addquestion.html.php';
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
    $activePage = 'addquestion';
    $users = selectAll($pdo, "user_account");
    $modules = selectAll($pdo, "module");
    ob_start();
    include PUBLIC_TEMPLATES . 'addquestion.html.php';
    $output = ob_get_clean();
}
include PUBLIC_TEMPLATES . 'layout.html.php';
?>
