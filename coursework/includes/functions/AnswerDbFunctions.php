<?php
/**
 * Answer Functions
 * All database operations related to answers.
 */

function getAnswer($pdo, $answer_id) {
    return getById($pdo, 'answer', $answer_id);
}

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

function getTotalAnswersForQuestion($pdo, $question_id) {
    $query = $pdo->prepare('SELECT COUNT(*) FROM answer WHERE question_id = :question_id');
    $query->bindValue(':question_id', $question_id);
    $query->execute();
    $row = $query->fetch();
    return $row[0];
}

function getTotalAnswers($pdo) {
    $query = $pdo->query('SELECT COUNT(*) FROM answer');
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
