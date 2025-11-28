<?php
try {
    include 'includes/DatabaseConnection.php';
    include 'includes/DataBaseFunctions.php';

    // Get filter parameters
    $moduleFilter = isset($_GET['module']) && $_GET['module'] !== '' ? intval($_GET['module']) : null;
    
    // Get all active modules for the filter dropdown (public view)
    $modules = selectAll($pdo, 'module');
    
    // Get questions - public view hides questions from deleted users/modules
    $questions = getQuestionList($pdo, $moduleFilter, null, true);
    $title = 'question list';
    $totalQuestions = getTotalQuestions($pdo);
    $activePage = 'questions';

    ob_start();
    include 'templates/questions.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}
include 'templates/layout.html.php';
