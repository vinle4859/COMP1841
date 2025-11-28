<?php

function query($pdo, $sql, $parameters=[]) {
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
}

function getQuestionList($pdo, $module_id = null, $user_id = null, $publicView = false) {
    // For public view: show [Deleted]/[Archived] as replacement names
    // For admin view: show username [Deleted] / modulename [Archived] labels
    if ($publicView) {
        $sql = 'SELECT q.question_id, q.title, q.content, q.image, q.created_at, 
                u.email, 
                CASE WHEN u.status = \'deleted\' THEN \'[Deleted]\' ELSE u.username END as username,
                CASE WHEN m.status = \'deleted\' THEN \'[Archived]\' ELSE m.module_name END as module_name, 
                m.module_id, u.user_id, u.status as user_status, m.status as module_status
        FROM question q
        INNER JOIN user_account u ON q.user_id = u.user_id
        INNER JOIN module m ON q.module_id = m.module_id';
    } else {
        $sql = 'SELECT q.question_id, q.title, q.content, q.image, q.created_at, 
                u.email, 
                CASE WHEN u.status = \'deleted\' THEN CONCAT(u.username, \' [Deleted]\') ELSE u.username END as username,
                CASE WHEN m.status = \'deleted\' THEN CONCAT(m.module_name, \' [Archived]\') ELSE m.module_name END as module_name, 
                m.module_id, u.user_id, u.status as user_status, m.status as module_status
        FROM question q
        INNER JOIN user_account u ON q.user_id = u.user_id
        INNER JOIN module m ON q.module_id = m.module_id';
    }
    
    $params = [];
    $conditions = [];
    
    if ($module_id !== null) {
        $conditions[] = 'q.module_id = :module_id';
        $params[':module_id'] = $module_id;
    }
    if ($user_id !== null) {
        $conditions[] = 'q.user_id = :user_id';
        $params[':user_id'] = $user_id;
    }
    
    if (!empty($conditions)) {
        $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }
    
    $sql .= ' ORDER BY q.created_at DESC';
    $questions = query($pdo, $sql, $params);
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
        'message' => 'message_id',
        'answer' => 'answer_id'
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

/**
 * Return a question row (with user/module info) and its answers (with user info).
 * Returns ['question' => array|null, 'answers' => array]
 * @param bool $publicView If true, show [Deleted]/[Archived] as replacement; if false, append to name
 */
function getQuestionDetail($pdo, $question_id, $publicView = false) {
    if ($publicView) {
        // Public view: [Deleted]/[Archived] replaces the name
        $sql = 'SELECT q.question_id, q.title, q.content, q.image, q.created_at, 
                CASE WHEN m.status = \'deleted\' THEN \'[Archived]\' ELSE m.module_name END as module_name, 
                CASE WHEN u.status = \'deleted\' THEN \'[Deleted]\' ELSE u.username END as username, 
                u.email, q.user_id, q.module_id, u.status as user_status, m.status as module_status
                FROM question q
                INNER JOIN user_account u ON q.user_id = u.user_id
                INNER JOIN module m ON q.module_id = m.module_id
                WHERE q.question_id = :id';
    } else {
        // Admin view: name [Deleted]/[Archived] appended
        $sql = 'SELECT q.question_id, q.title, q.content, q.image, q.created_at, 
                CASE WHEN m.status = \'deleted\' THEN CONCAT(m.module_name, \' [Archived]\') ELSE m.module_name END as module_name, 
                CASE WHEN u.status = \'deleted\' THEN CONCAT(u.username, \' [Deleted]\') ELSE u.username END as username, 
                u.email, q.user_id, q.module_id, u.status as user_status, m.status as module_status
                FROM question q
                INNER JOIN user_account u ON q.user_id = u.user_id
                INNER JOIN module m ON q.module_id = m.module_id
                WHERE q.question_id = :id';
    }
    $query = query($pdo, $sql, [':id' => $question_id]);
    $question = $query->fetch();

    if ($publicView) {
        // Public view: [Deleted] replaces username for answers
        $sql = 'SELECT a.answer_id, a.content, a.image, a.created_at, 
                CASE WHEN ua.status = \'deleted\' THEN \'[Deleted]\' ELSE ua.username END as username, 
                ua.email, ua.status as user_status
                FROM answer a
                INNER JOIN user_account ua ON a.user_id = ua.user_id
                WHERE a.question_id = :id
                ORDER BY a.created_at ASC';
    } else {
        // Admin view: username [Deleted] appended for answers
        $sql = 'SELECT a.answer_id, a.content, a.image, a.created_at, 
                CASE WHEN ua.status = \'deleted\' THEN CONCAT(ua.username, \' [Deleted]\') ELSE ua.username END as username, 
                ua.email, ua.status as user_status
                FROM answer a
                INNER JOIN user_account ua ON a.user_id = ua.user_id
                WHERE a.question_id = :id
                ORDER BY a.created_at ASC';
    }
    $answersQuery = query($pdo, $sql, [':id' => $question_id]);
    $answers = $answersQuery->fetchAll();

    return ['question' => $question, 'answers' => $answers];
}

/**
 * Add a new answer to a question.
 */
function addAnswer($pdo, $question_id, $content, $user_id, $image = null) {
    $sql = 'INSERT INTO answer (content, image, user_id, question_id) 
            VALUES (:content, :image, :user_id, :question_id)';
    $params = [
        ':content' => $content,
        ':image' => $image,
        ':user_id' => $user_id,
        ':question_id' => $question_id
    ];
    query($pdo, $sql, $params);
    return $pdo->lastInsertId();
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

function deleteUser($pdo, $user_id) {
    // Soft delete: mark user as deleted instead of removing from database
    // This preserves referential integrity - questions/answers keep valid foreign keys
    $sql = 'UPDATE user_account SET status = \'deleted\' WHERE user_id = :id';
    query($pdo, $sql, [':id' => $user_id]);
}

function deleteModule($pdo, $module_id) {
    // Soft delete: mark module as deleted instead of removing from database
    // This preserves referential integrity - questions keep valid foreign keys
    $sql = 'UPDATE module SET status = \'deleted\' WHERE module_id = :id';
    query($pdo, $sql, [':id' => $module_id]);
}

function updateUser($pdo, $user_id, $username, $email) {
    $sql = 'UPDATE user_account SET username = :username, email = :email WHERE user_id = :id';
    $params = [':username' => $username, ':email' => $email, ':id' => $user_id];
    query($pdo, $sql, $params);
}

function addUser($pdo, $username, $email, $password) {
    $sql = 'INSERT INTO user_account (username, email, `password`) VALUES (:username, :email, :password)';
    $params = [':username' => $username, ':email' => $email, ':password' => $password];
    query($pdo, $sql, $params);
    return $pdo->lastInsertId();
}

function updateModule($pdo, $module_id, $module_name) {
    $sql = 'UPDATE module SET module_name = :module_name WHERE module_id = :id';
    $params = [':module_name' => $module_name, ':id' => $module_id];
    query($pdo, $sql, $params);
}

/**
 * Insert a new module and return its id.
 */
function addModule($pdo, $module_name) {
    $sql = 'INSERT INTO module (module_name) VALUES (:module_name)';
    $params = [':module_name' => $module_name];
    query($pdo, $sql, $params);
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

function selectAll($pdo, $table, $includeDeleted = false) {
    $tables = ['user_account', 'module'];

    // Check if the requested table is in the safe list
    if (!in_array($table, $tables)) {
        throw new \Exception("Invalid table name.");
    }
    
    // By default, only return active records
    if ($includeDeleted) {
        $sql = "SELECT * FROM $table ORDER BY status ASC";
    } else {
        $sql = "SELECT * FROM $table WHERE status = 'active'";
    }
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

function getContactMessage($pdo, $message_id) {
    $message = getById($pdo, 'message', $message_id);
    return $message;
}

function setMessageStatus($pdo, $message_id, $status) {
    $sql = 'UPDATE message SET status = :status WHERE message_id = :id';
    $params = [':status' => $status, ':id' => $message_id];
    query($pdo, $sql, $params);
}

function deleteMessage($pdo, $message_id) {
    $sql = 'DELETE FROM message WHERE message_id = :id';
    $parameters = [':id' => $message_id];
    query($pdo, $sql, $parameters);
}

/**
 * Restore a soft-deleted user
 */
function restoreUser($pdo, $user_id) {
    $sql = 'UPDATE user_account SET status = \'active\' WHERE user_id = :id';
    query($pdo, $sql, [':id' => $user_id]);
}

/**
 * Restore a soft-deleted module
 */
function restoreModule($pdo, $module_id) {
    $sql = 'UPDATE module SET status = \'active\' WHERE module_id = :id';
    query($pdo, $sql, [':id' => $module_id]);
}

/**
 * Get a single answer by ID
 */
function getAnswer($pdo, $answer_id) {
    return getById($pdo, 'answer', $answer_id);
}

/**
 * Get all answers for a specific question (admin view with user info)
 */
function getAnswersByQuestion($pdo, $question_id) {
    $sql = 'SELECT a.answer_id, a.content, a.image, a.created_at, a.question_id,
            CASE WHEN u.status = \'deleted\' THEN CONCAT(u.username, \' [Deleted]\') ELSE u.username END as username,
            u.email, u.user_id, u.status as user_status
            FROM answer a
            INNER JOIN user_account u ON a.user_id = u.user_id
            WHERE a.question_id = :question_id
            ORDER BY a.created_at ASC';
    $query = query($pdo, $sql, [':question_id' => $question_id]);
    return $query->fetchAll();
}

/**
 * Update an existing answer
 */
function updateAnswer($pdo, $answer_id, $content, $image = null) {
    if ($image !== null) {
        $sql = 'UPDATE answer SET content = :content, image = :image WHERE answer_id = :id';
        $params = [':content' => $content, ':image' => $image, ':id' => $answer_id];
    } else {
        $sql = 'UPDATE answer SET content = :content WHERE answer_id = :id';
        $params = [':content' => $content, ':id' => $answer_id];
    }
    query($pdo, $sql, $params);
}

/**
 * Delete an answer (hard delete since answers don't have dependencies)
 */
function deleteAnswer($pdo, $answer_id) {
    $sql = 'DELETE FROM answer WHERE answer_id = :id';
    query($pdo, $sql, [':id' => $answer_id]);
}
