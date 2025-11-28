<?php
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
include '../includes/InputHelpers.php';

$error = null;
try {
    // Get question ID from POST or GET
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $question_id = (int) post_or_redirect('question_id', 'questions.php');
    } else {
        $question_id = (int) get_or_redirect('id', 'questions.php');
    }
    // Load existing question
    $question = getQuestion($pdo, $question_id);

    // Get other question fields for POST processing
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = trim($_POST['content'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $user = trim($_POST['user'] ?? '');
        $module = trim($_POST['module'] ?? '');
        
        // Handle image upload
        $uploadResult = handleImageUpload('image', '../images/');
        
        if (!$uploadResult['success']) {
            $error = 'Image upload failed: ' . $uploadResult['error'];
            // preserve submitted values
            $question['title'] = $title;
            $question['content'] = $content;
            $question['user_id'] = $user;
            $question['module_id'] = $module;
        } else {
            // Determine final image: new upload, or keep existing
            $final_image = $uploadResult['filename'] ?? $question['image'];
            
            // VALIDATION: require title, content, user and module
            if ($title === '' || $content === '' || $user === '' || $module === '') {
                $error = 'Please provide title, content, user and module.';
                // preserve submitted values into $question so template shows them
                $question['title'] = $title;
                $question['content'] = $content;
                $question['user_id'] = $user;
                $question['module_id'] = $module;
            } else {
                updateQuestion($pdo, $question_id, $content, $title, $final_image, $user, $module);
                header('Location: questions.php');
                exit;
            }
        }
    }

    // Render form for viewing
    $title = 'Edit question';
    // Include deleted users/modules so current selection is visible even if deleted
    $users = selectAll($pdo, 'user_account', true);  // true = include deleted
    $modules = selectAll($pdo, 'module', true);      // true = include deleted
    $current_user = getUser($pdo, $question['user_id']);
    $current_module = getModule($pdo, $question['module_id']);

    ob_start();
    include '../templates/editquestion.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Error has occured';
    $output = 'A database error occurred: ' . $e->getMessage();
}

include '../templates/admin_layout.html.php';
?>
