<?php
include 'includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';
include FUNCTIONS_PATH . 'AnswerDbFunctions.php';

// Get stats for home page
$totalQuestions = getTotalQuestions($pdo);
$totalAnswers = getTotalAnswers($pdo);

// Get recent questions (limit 5)
$recentQuestions = getQuestionList($pdo, null, null, true);
$recentQuestions = array_slice($recentQuestions, 0, 5);

$title = 'Home - Student Forum';
$activePage = 'home';
ob_start();
include PUBLIC_TEMPLATES . 'home.html.php';
$output = ob_get_clean();
include PUBLIC_TEMPLATES . 'layout.html.php';
?>
