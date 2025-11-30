<?php
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';

try {
    // Get filter parameters
    $moduleFilter = isset($_GET['module']) && $_GET['module'] !== '' ? intval($_GET['module']) : null;
    $authorSearch = isset($_GET['author']) ? trim($_GET['author']) : null;
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : null;
    
    // Minimum 2 characters for search (silently ignore short searches)
    if ($searchTerm && strlen($searchTerm) < 2) {
        $searchTerm = null;
    }
    if ($authorSearch && strlen($authorSearch) < 2) {
        $authorSearch = null;
    }
    
    // Get all modules for the filter dropdown
    $modules = selectAll($pdo, 'module');
    
    $questions = getQuestionList($pdo, $moduleFilter, null, false, $searchTerm, $authorSearch);
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
