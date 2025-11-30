<?php
/**
 * User Functions
 * All database operations related to users.
 */

function getUser($pdo, $user_id) {
    return getById($pdo, 'user_account', $user_id);
}

function addUser($pdo, $username, $email, $password) {
    // Hash password before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = 'INSERT INTO user_account (username, email, `password`) VALUES (:username, :email, :password)';
    $params = [':username' => $username, ':email' => $email, ':password' => $hashedPassword];
    query($pdo, $sql, $params);
    return $pdo->lastInsertId();
}

function updateUser($pdo, $user_id, $username, $email) {
    $sql = 'UPDATE user_account SET username = :username, email = :email WHERE user_id = :id';
    $params = [':username' => $username, ':email' => $email, ':id' => $user_id];
    query($pdo, $sql, $params);
}

function deleteUser($pdo, $user_id) {
    // Soft delete: mark user as deleted instead of removing from database
    $sql = 'UPDATE user_account SET status = \'deleted\' WHERE user_id = :id';
    query($pdo, $sql, [':id' => $user_id]);
}

function restoreUser($pdo, $user_id) {
    $sql = 'UPDATE user_account SET status = \'active\' WHERE user_id = :id';
    query($pdo, $sql, [':id' => $user_id]);
}

function searchUsers($pdo, $searchTerm) {
    $sql = 'SELECT user_id, username, email, status, created_at 
            FROM user_account 
            WHERE username LIKE :search OR email LIKE :search 
            ORDER BY status ASC, username ASC';
    $query = query($pdo, $sql, [':search' => '%' . $searchTerm . '%']);
    return $query->fetchAll();
}

function updateUserPassword($pdo, $user_id, $hashedPassword) {
    $sql = 'UPDATE user_account SET password = :password WHERE user_id = :id';
    $params = [':password' => $hashedPassword, ':id' => $user_id];
    query($pdo, $sql, $params);
}

function getUserProfile($pdo, $user_id) {
    $sql = 'SELECT u.user_id, u.username, u.email, u.status, u.created_at,
            (SELECT COUNT(*) FROM question WHERE user_id = u.user_id) as question_count,
            (SELECT COUNT(*) FROM answer WHERE user_id = u.user_id) as answer_count
            FROM user_account u
            WHERE u.user_id = :id';
    $query = query($pdo, $sql, [':id' => $user_id]);
    return $query->fetch();
}

function checkCurrentPassword($pdo, $user_id, $password) {
    $sql = 'SELECT password FROM user_account WHERE user_id = :id';
    $query = query($pdo, $sql, [':id' => $user_id]);
    $user = $query->fetch();
    if ($user && password_verify($password, $user['password'])) {
        return true;
    }
    return false;
}
