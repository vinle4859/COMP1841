<?php
include '../includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';

try {
    // Get filter parameters
    $moduleFilter = isset($_GET['module']) && $_GET['module'] !== '' ? intval($_GET['module']) : null;
    $userFilter = isset($_GET['user']) && $_GET['user'] !== '' ? intval($_GET['user']) : null;
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : null;
    
    // Get all modules and users for the filter dropdowns
    $modules = selectAll($pdo, 'module');
    $users = selectAll($pdo, 'user_account');
    
    $questions = getQuestionList($pdo, $moduleFilter, $userFilter, false, $searchTerm);
    $title = 'Question List';
    $totalQuestions = getTotalQuestions($pdo);
    $activePage = 'questions';

    ob_start();
    include ADMIN_TEMPLATES . 'questions.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}
include ADMIN_TEMPLATES . 'layout.html.php';
