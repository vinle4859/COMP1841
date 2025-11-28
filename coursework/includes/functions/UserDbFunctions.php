<?php
/**
 * User Functions
 * All database operations related to users.
 */

function getUser($pdo, $user_id) {
    return getById($pdo, 'user_account', $user_id);
}

function addUser($pdo, $username, $email, $password) {
    $sql = 'INSERT INTO user_account (username, email, `password`) VALUES (:username, :email, :password)';
    $params = [':username' => $username, ':email' => $email, ':password' => $password];
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
