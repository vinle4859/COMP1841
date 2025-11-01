<?php
    include 'includes/DatabaseConnection.php';
    include 'includes/DataBaseFunctions.php';

    try {
        // Get question info (with user and module)
        $sql = 'SELECT q.question_id, q.title, q.content, q.image, q.created_at, m.module_name, u.username, u.email
                FROM question q
                INNER JOIN user_account u ON q.user_id = u.user_id
                INNER JOIN module m ON q.module_id = m.module_id
                WHERE q.question_id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();
        $question = $stmt->fetch();

        // Get answers for this question (with user info)
        $sql = 'SELECT a.answer_id, a.content, a.image, a.created_at, ua.username, ua.email
                FROM answer a
                INNER JOIN user_account ua ON a.user_id = ua.user_id
                WHERE a.question_id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();
        $answers = $stmt->fetchAll();
    } catch (PDOException $e) {
        $title = 'An error has occured';
        $output = 'Database error: ' . $e->getMessage();
        $question = null;
        $answers = [];
    }
    include 'templates/questiondetail.html.php';
?>
