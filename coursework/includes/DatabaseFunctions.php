<?php

function query($pdo, $sql, $parameters=[]) {
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
}

function getQuestionList($pdo) {
    $sql = 'SELECT question_id, title, content, `image`, email, username, module_name 
    FROM question
    INNER JOIN user_account ON question.user_id = user_account.user_id
    INNER JOIN module ON question.module_id = module.module_id';
    $questions = query($pdo, $sql);
    return $questions;
}

function getTotalQuestions($pdo) {
    $query = query($pdo, 'SELECT COUNT(*) FROM question');
    $row = $query->fetch();
    return $row[0];
}

function getTotalAnswers($pdo, $question_id) {
    $query = $pdo->prepare('SELECT COUNT(*) FROM answer 
    WHERE question_id = :question_id');
    $query->bindValue(':question_id', $question_id);
    $query->execute();
    $row = $query->fetch();
    return $row[0];
}

function getQuestion($pdo, $questionId) {
    $sql = 'SELECT * FROM question WHERE question_id = :id';
    $parameters = [':id' => $questionId];
    $query = query($pdo, $sql, $parameters);
    $question = $query->fetch();
    return $question;
}

function updateQuestion($pdo, $question_id, $content, $title) {
    $sql = 'UPDATE question SET content = :content, title = :title 
    WHERE question_id = :id';
    $parameters = [':id' => $question_id, ':content' => $content, 
    ':title' => $title];
    query($pdo, $sql, $parameters);
}

function deleteQuestion($pdo, $question_id) {
    $sql = 'DELETE FROM question WHERE question_id = :id';
    $parameters = [':id' => $question_id];
    query($pdo, $sql, $parameters);
}

function addQuestion($pdo, $content, $image, $title, $user_id, $module_id) {
    $sql = 'INSERT INTO question SET content = :content, image = :image, 
    title = :title, user_id = :user_id, module_id = :module_id';
    $parameters = [':content' => $content, ':image' => $image, ':title' => $title, 
    ':user_id' => $user_id, ':module_id' => $module_id];
    query($pdo, $sql, $parameters);
}

function selectAll($pdo, $table) {
    $tables = ['user_account', 'module'];

    // Check if the requested table is in the safe list
    if (!in_array($table, $allowedTables)) {
        throw new \Exception("Invalid table name.");
    }
    $sql = "SELECT * FROM $table";
    $data = query($pdo, $sql);
    return $data->fetchAll();
}
