<?php
/**
 * Answer Functions
 * All database operations related to answers.
 */

function getAnswer($pdo, $answer_id) {
    return getById($pdo, 'answer', $answer_id);
}

function getTotalAnswersForQuestion($pdo, $question_id) {
    $query = $pdo->prepare('SELECT COUNT(*) FROM answer WHERE question_id = :question_id');
    $query->bindValue(':question_id', $question_id);
    $query->execute();
    $row = $query->fetch();
    return $row[0];
}

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

function deleteAnswer($pdo, $answer_id) {
    $sql = 'DELETE FROM answer WHERE answer_id = :id';
    query($pdo, $sql, [':id' => $answer_id]);
}

function getAnswersByUser($pdo, $user_id, $limit = null) {
    $sql = 'SELECT a.answer_id, a.content, a.image, a.created_at, a.question_id,
            q.title as question_title,
            u.username, u.email
            FROM answer a
            INNER JOIN question q ON a.question_id = q.question_id
            INNER JOIN user_account u ON a.user_id = u.user_id
            WHERE a.user_id = :user_id
            ORDER BY a.created_at DESC';
    if ($limit !== null) {
        $sql .= ' LIMIT ' . intval($limit);
    }
    $query = query($pdo, $sql, [':user_id' => $user_id]);
    return $query->fetchAll();
}

/**
 * Accept an answer - only question owner can do this.
 * First clears any previously accepted answer for the question, then sets the new one.
 */
function acceptAnswer($pdo, $answer_id, $question_id) {
    // Clear any previously accepted answer for this question
    $sql = 'UPDATE answer SET is_accepted = 0 WHERE question_id = :question_id';
    query($pdo, $sql, [':question_id' => $question_id]);
    
    // Accept the specified answer
    $sql = 'UPDATE answer SET is_accepted = 1 WHERE answer_id = :answer_id';
    query($pdo, $sql, [':answer_id' => $answer_id]);
}

/**
 * Unaccept an answer
 */
function unacceptAnswer($pdo, $answer_id) {
    $sql = 'UPDATE answer SET is_accepted = 0 WHERE answer_id = :answer_id';
    query($pdo, $sql, [':answer_id' => $answer_id]);
}
