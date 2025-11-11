<?php

include 'includes/DataBaseFunctions.php';
include 'includes/InputHelpers.php';

if (isset($_POST['content'])) {
    try {
        include 'includes/DatabaseConnection.php';

        // Read and trim inputs using helper
        $content = validateAndTrim('content');
        $image = validateAndTrim('image');
        $titleInput = validateAndTrim('title');
        // user and module are selections submitted as strings; read trimmed values
        $user = validateAndTrim('user');
        $module = validateAndTrim('module');

        // Minimal validation (content and title required). For module, ensure it's present and numeric > 0.
        if ($content === '' || $titleInput === '' || $module === '' || (int)$module <= 0) {
            $title = 'Add new question';
            $error = 'Please provide a title, content and select a module.';
            // database connection is already included earlier in this try block
            $users = selectAll($pdo, "user_account");
            $modules = selectAll($pdo, "module");
            ob_start();
            include 'templates/addquestion.html.php';
            $output = ob_get_clean();
            // do not exit; fall through to the single layout include at the end of the file
        } else {
            addQuestion($pdo, $content, $image, $titleInput, $user, $module);
            header('location: questions.php');
            exit;
        }
    } catch (PDOException $e) {
        $title = 'An error has occured';
        $output = 'Database error: ' . $e->getMessage();
    }
} else {
    include 'includes/DatabaseConnection.php';  
    $title = 'Add new question';
    $users = selectAll($pdo, "user_account");
    $modules = selectAll($pdo, "module");
    ob_start();
    include 'templates/addquestion.html.php';
    $output = ob_get_clean();
}
include 'templates/layout.html.php';
?>
