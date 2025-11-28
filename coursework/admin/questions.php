<?php
try {
    include '../includes/DatabaseConnection.php';
    include '../includes/DataBaseFunctions.php';

    // Get filter parameters
    $moduleFilter = isset($_GET['module']) && $_GET['module'] !== '' ? intval($_GET['module']) : null;
    $userFilter = isset($_GET['user']) && $_GET['user'] !== '' ? intval($_GET['user']) : null;
    
    // Get all modules and users for the filter dropdowns
    $modules = selectAll($pdo, 'module');
    $users = selectAll($pdo, 'user_account');
    
    $questions = getQuestionList($pdo, $moduleFilter, $userFilter);
    $title = 'question list';
    $totalQuestions = getTotalQuestions($pdo);
    $activePage = 'questions';

    ob_start();
    include '../templates/admin_questions.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}
include '../templates/admin_layout.html.php';
