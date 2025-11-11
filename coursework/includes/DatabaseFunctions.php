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

function getById($pdo, $table, $id) {
    $table_ids = [
        'question' => 'question_id',
        'user_account' => 'user_id',
        'module' => 'module_id',
        'message' => 'message_id'
    ];

    if (!isset($table_ids[$table])) {
        throw new Exception("Invalid table requested.");
    }

    $table_id = $table_ids[$table];
    $sql = "SELECT * FROM {$table} WHERE {$table_id} = :id";
    $parameters = [':id' => $id];
    $query = query($pdo, $sql, $parameters);
    return $query->fetch();
}

function getQuestion($pdo, $question_id) {
    $question = getById($pdo, 'question', $question_id);
    return $question;
}

function getModule($pdo, $module_id) {
    $module = getById($pdo, 'module', $module_id);
    return $module;
}

function getUser($pdo, $user_id) {
    $user = getById($pdo, 'user_account', $user_id);
    return $user;
}

function updateQuestion($pdo, $question_id, $content, $title, $image, $user_id, $module_id) {
    $sql = 'UPDATE question SET content = :content, title = :title, image = :image, 
    user_id = :user_id, module_id = :module_id 
    WHERE question_id = :id';
    $parameters = [
        ':id' => $question_id, 
        ':content' => $content, 
        ':title' => $title, 
        ':image' => $image, 
        ':user_id' => $user_id, 
        ':module_id' => $module_id
    ];
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
    $parameters = [
        ':content' => $content, 
        ':image' => $image,
        ':title' => $title, 
        ':user_id' => $user_id, 
        ':module_id' => $module_id
    ];
    query($pdo, $sql, $parameters);
}

function selectAll($pdo, $table) {
    $tables = ['user_account', 'module'];

    // Check if the requested table is in the safe list
    if (!in_array($table, $tables)) {
        throw new \Exception("Invalid table name.");
    }
    $sql = "SELECT * FROM $table";
    $data = query($pdo, $sql);
    return $data->fetchAll();
}

function addMessage($pdo, $subject, $content, $sender_name = null, $sender_email = null, $user_id = null) {
    // Insert a message. For Guest submissions, provide sender_name and sender_email.
    // For logged-in users, provide user_id (sender_name/email may be NULL).
    $sql = 'INSERT INTO message (user_id, sender_name, sender_email, subject, content, status) '
         . 'VALUES (:user_id, :sender_name, :sender_email, :subject, :content, :status)';
    $params = [
        ':user_id' => $user_id,
        ':sender_name' => $sender_name,
        ':sender_email' => $sender_email,
        ':subject' => $subject,
        ':content' => $content,
        ':status' => 'new'
    ];
    query($pdo, $sql, $params);
    return $pdo->lastInsertId();
}

function getMessageList($pdo, $status = null) {
    // Return the message rows using the DB's `content` column and user info as `username` and `email`.
    $sql = "SELECT m.*, u.username AS username, u.email AS email
            FROM message m
            LEFT JOIN user_account u ON m.user_id = u.user_id";
    $params = [];
    if ($status !== null) {
        $sql .= ' WHERE m.status = :status';
        $params[':status'] = $status;
    }
    $sql .= ' ORDER BY m.created_at DESC';
    $query = query($pdo, $sql, $params);
    return $query->fetchAll();
}

function getMessage($pdo, $message_id) {
    $message = getById($pdo, 'message', $message_id);
    return $message;
}

function setMessageStatus($pdo, $message_id, $status) {
    $sql = 'UPDATE message SET status = :status WHERE message_id = :id';
    $params = [':status' => $status, ':id' => $message_id];
    query($pdo, $sql, $params);
}
