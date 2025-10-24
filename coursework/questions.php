<?php
try {
    include 'includes/DatabaseConnection.php';

    $sql = 'SELECT question_id, content, `image`, email, username, module_name 
    FROM question
    INNER JOIN user_account ON question.user_id = user_account.user_id
    INNER JOIN module ON question.module_id = module.module_id';
    $questions = $pdo->query($sql);
    $title = 'question list';

    ob_start();
    include 'templates/questions.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}
include 'templates/layout.html.php';
