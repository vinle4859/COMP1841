<?php
include 'includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(); // Track last_page for redirect after login

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';

try {
    // Get filter parameters
    $moduleFilter = isset($_GET['module']) && $_GET['module'] !== '' ? intval($_GET['module']) : null;
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : null;
    $authorSearch = isset($_GET['author']) ? trim($_GET['author']) : null;
    
    // Minimum 2 characters for search (silently ignore short searches)
    if ($searchTerm && strlen($searchTerm) < 2) {
        $searchTerm = null;
    }
    if ($authorSearch && $authorSearch !== 'mine' && strlen($authorSearch) < 2) {
        $authorSearch = null;
    }
    
    // Empty strings should be null (no filter)
    if ($searchTerm === '') $searchTerm = null;
    if ($authorSearch === '') $authorSearch = null;
    
    // Special case: "mine" shows only current user's questions
    $userFilter = null;
    if ($authorSearch === 'mine' && isLoggedIn()) {
        $userFilter = getCurrentUserId();
        $authorSearch = null; // Clear so we don't also do LIKE search
    }
    
    // Get all active modules for the filter dropdown (public view)
    $modules = selectAll($pdo, 'module');
    
    // Get questions - public view hides questions from deleted users/modules
    $questions = getQuestionList($pdo, $moduleFilter, $userFilter, true, $searchTerm, $authorSearch);
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
