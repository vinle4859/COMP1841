<?php
    include '../includes/DatabaseConnection.php';
    include '../includes/DatabaseFunctions.php';
    include '../includes/InputHelpers.php';

    // Read messages from URL (set by addanswer.php after redirect)
    $answerError = $_GET['error'] ?? '';
    $answerSuccess = $_GET['success'] ?? '';

    try {
        $id = get_or_redirect('id', 'questions.php');
        
        // Use the helper function
        $detail = getQuestionDetail($pdo, $id);
        $question = $detail['question'];
        $answers = $detail['answers'];
        
        // Get users list for answer dropdown
        $users = selectAll($pdo, 'user_account');

        // Render the detail template into $output so layout can place it in the page
        // Set a sensible page title first (explicit if/else for clarity)
        if (isset($question['title']) && $question['title'] !== '') {
            $title = $question['title'];
        } else {
            $title = 'Question detail';
        }
        $activePage = 'questions';
        ob_start();
        include '../templates/admin_questiondetail.html.php';
        $output = ob_get_clean();
    } catch (PDOException $e) {
        $title = 'An error has occured';
        $output = 'Database error: ' . $e->getMessage();
        $question = null;
        $answers = [];
    }
    include '../templates/admin_layout.html.php';
?>
