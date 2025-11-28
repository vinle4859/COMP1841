<?php
try {
    include '../includes/DatabaseConnection.php';
    include '../includes/DatabaseFunctions.php';
    $question_id = post_or_redirect('question_id', 'questions.php');
    deleteQuestion($pdo, $question_id);
    header('location: questions.php');
    exit;
} catch (PDOException $e) {
    $title = "An error has occured";
    $output = 'Unable to establish Database Connection to delete question: '
     . $e->getMessage();
}
// On success we redirected; render layout only when there was an error set above.
if (!empty($output)) {
    include '../templates/admin_layout.html.php';
}
?>
