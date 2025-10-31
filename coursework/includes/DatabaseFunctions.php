<?php
function getTotalQuestions($pdo) {
    $query = $pdo->prepare('SELECT COUNT(*) FROM question');
    $query->execute();
    $row = $query->fetch();
    return $row[0];
}
