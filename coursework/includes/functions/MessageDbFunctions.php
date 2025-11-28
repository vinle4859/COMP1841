<?php
/**
 * Message Functions
 * All database operations related to contact messages.
 */

function getContactMessage($pdo, $message_id) {
    $sql = 'SELECT m.*, u.username 
            FROM message m 
            LEFT JOIN user_account u ON m.user_id = u.user_id 
            WHERE m.message_id = :id';
    $query = query($pdo, $sql, [':id' => $message_id]);
    return $query->fetch();
}

function getMessageList($pdo, $status = null) {
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

function addMessage($pdo, $subject, $content, $sender_name = null, $sender_email = null, $user_id = null) {
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

function setMessageStatus($pdo, $message_id, $status) {
    $sql = 'UPDATE message SET status = :status WHERE message_id = :id';
    $params = [':status' => $status, ':id' => $message_id];
    query($pdo, $sql, $params);
}

function deleteMessage($pdo, $message_id) {
    $sql = 'DELETE FROM message WHERE message_id = :id';
    query($pdo, $sql, [':id' => $message_id]);
}
