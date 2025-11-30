<?php
include 'includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(); // Track last_page for redirect after login

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'QuestionDbFunctions.php';

// Show recent questions for all users (logged-in and guests)
$recentQuestions = getQuestionList($pdo, null, null, true);
$recentQuestions = array_slice($recentQuestions, 0, 5);

$title = 'Home - Student Forum';
$activePage = 'home';
ob_start();
include PUBLIC_TEMPLATES . 'home.html.php';
$output = ob_get_clean();
include PUBLIC_TEMPLATES . 'layout.html.php';
