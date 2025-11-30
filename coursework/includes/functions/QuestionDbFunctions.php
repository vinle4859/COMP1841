<?php
/**
 * Question Functions
 * All database operations related to questions.
 */

function getQuestion($pdo, $question_id) {
    return getById($pdo, 'question', $question_id);
}

function getQuestionList($pdo, $module_id = null, $user_id = null, $publicView = false, $searchTerm = null, $authorSearch = null) {
    if ($publicView) {
        $sql = 'SELECT q.question_id, q.title, q.content, q.image, q.created_at, q.view_count,
                u.email, 
                CASE WHEN u.status = \'deleted\' THEN \'[Deleted]\' ELSE u.username END as username,
                CASE WHEN m.status = \'deleted\' THEN \'[Archived]\' ELSE m.module_name END as module_name, 
                m.module_id, u.user_id, u.status as user_status, m.status as module_status
        FROM question q
        INNER JOIN user_account u ON q.user_id = u.user_id
        INNER JOIN module m ON q.module_id = m.module_id';
    } else {
        $sql = 'SELECT q.question_id, q.title, q.content, q.image, q.created_at, q.view_count,
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
    if ($searchTerm !== null && $searchTerm !== '') {
        $conditions[] = '(q.title LIKE :search OR q.content LIKE :search)';
        $params[':search'] = '%' . $searchTerm . '%';
    }
    if ($authorSearch !== null && $authorSearch !== '') {
        $conditions[] = 'u.username LIKE :author';
        $params[':author'] = '%' . $authorSearch . '%';
    }
    
    if (!empty($conditions)) {
        $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }
    
    $sql .= ' ORDER BY q.created_at DESC';
    $questions = query($pdo, $sql, $params);
    return $questions->fetchAll();
}

function getQuestionDetail($pdo, $question_id, $publicView = false) {
    if ($publicView) {
        $sql = 'SELECT q.question_id, q.title, q.content, q.image, q.created_at, q.view_count,
                CASE WHEN m.status = \'deleted\' THEN \'[Archived]\' ELSE m.module_name END as module_name, 
                CASE WHEN u.status = \'deleted\' THEN \'[Deleted]\' ELSE u.username END as username, 
                u.email, q.user_id, q.module_id, u.status as user_status, m.status as module_status
                FROM question q
                INNER JOIN user_account u ON q.user_id = u.user_id
                INNER JOIN module m ON q.module_id = m.module_id
                WHERE q.question_id = :id';
    } else {
        $sql = 'SELECT q.question_id, q.title, q.content, q.image, q.created_at, q.view_count,
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

    // Get answers with the same view logic
    if ($publicView) {
        $sql = 'SELECT a.answer_id, a.content, a.image, a.created_at, a.user_id, a.is_accepted,
                CASE WHEN ua.status = \'deleted\' THEN \'[Deleted]\' ELSE ua.username END as username, 
                ua.email, ua.status as user_status
                FROM answer a
                INNER JOIN user_account ua ON a.user_id = ua.user_id
                WHERE a.question_id = :id
                ORDER BY a.is_accepted DESC, a.created_at ASC';
    } else {
        $sql = 'SELECT a.answer_id, a.content, a.image, a.created_at, a.user_id, a.is_accepted,
                CASE WHEN ua.status = \'deleted\' THEN CONCAT(ua.username, \' [Deleted]\') ELSE ua.username END as username, 
                ua.email, ua.status as user_status
                FROM answer a
                INNER JOIN user_account ua ON a.user_id = ua.user_id
                WHERE a.question_id = :id
                ORDER BY a.is_accepted DESC, a.created_at ASC';
    }
    $answersQuery = query($pdo, $sql, [':id' => $question_id]);
    $answers = $answersQuery->fetchAll();

    return ['question' => $question, 'answers' => $answers];
}

function getTotalQuestions($pdo) {
    $query = query($pdo, 'SELECT COUNT(*) FROM question');
    $row = $query->fetch();
    return $row[0];
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
    return $pdo->lastInsertId();
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
    query($pdo, $sql, [':id' => $question_id]);
}

function incrementViewCount($pdo, $question_id) {
    $sql = 'UPDATE question SET view_count = view_count + 1 WHERE question_id = :id';
    query($pdo, $sql, [':id' => $question_id]);
}
