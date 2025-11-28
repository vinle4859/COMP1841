<?php
include '../includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include FUNCTIONS_PATH . 'UserDbFunctions.php';
include FUNCTIONS_PATH . 'ModuleDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

$error = null;
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $question_id = (int) post_or_redirect('question_id', 'questions.php');
    } else {
        $question_id = (int) get_or_redirect('id', 'questions.php');
    }
    $question = getQuestion($pdo, $question_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = trim($_POST['content'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $user = trim($_POST['user'] ?? '');
        $module = trim($_POST['module'] ?? '');
        
        $uploadResult = handleImageUpload('image', IMAGES_PATH);
        
        if (!$uploadResult['success']) {
            $error = 'Image upload failed: ' . $uploadResult['error'];
            $question['title'] = $title;
            $question['content'] = $content;
            $question['user_id'] = $user;
            $question['module_id'] = $module;
        } else {
            $final_image = $uploadResult['filename'] ?? $question['image'];
            
            if ($title === '' || $content === '' || $user === '' || $module === '') {
                $error = 'Please provide title, content, user and module.';
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

    $title = 'Edit question';
    $users = selectAll($pdo, 'user_account', true);
    $modules = selectAll($pdo, 'module', true);
    $current_user = getUser($pdo, $question['user_id']);
    $current_module = getModule($pdo, $question['module_id']);

    ob_start();
    include ADMIN_TEMPLATES . 'editquestion.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Error has occured';
    $output = 'A database error occurred: ' . $e->getMessage();
}

include ADMIN_TEMPLATES . 'layout.html.php';
?>
