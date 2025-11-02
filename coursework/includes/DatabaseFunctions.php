<?php
function getTotalQuestions($pdo) {
    $query = $pdo->prepare('SELECT COUNT(*) FROM question');
    $query->execute();
    $row = $query->fetch();
    return $row[0];
}

function getTotalAnswers($pdo, $questionId) {
    // Use a parameterized query to avoid SQL injection
    $query = $pdo->prepare('SELECT COUNT(*) FROM answer 
    WHERE question_id = :questionId');
    $query->bindValue(':questionId', $questionId);
    $query->execute();
    $row = $query->fetch();
    return $row[0];
}
