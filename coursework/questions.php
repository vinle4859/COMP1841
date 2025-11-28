<?php
include 'includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';

try {
    // Get filter parameters
    $moduleFilter = isset($_GET['module']) && $_GET['module'] !== '' ? intval($_GET['module']) : null;
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : null;
    
    // Get all active modules for the filter dropdown (public view)
    $modules = selectAll($pdo, 'module');
    
    // Get questions - public view hides questions from deleted users/modules
    $questions = getQuestionList($pdo, $moduleFilter, null, true, $searchTerm);
    $title = 'Question List';
    $totalQuestions = getTotalQuestions($pdo);
    $activePage = 'questions';

    ob_start();
    include PUBLIC_TEMPLATES . 'questions.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}
include PUBLIC_TEMPLATES . 'layout.html.php';
