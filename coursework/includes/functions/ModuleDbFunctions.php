<?php
/**
 * Module Functions
 * All database operations related to modules.
 */

function getModule($pdo, $module_id) {
    return getById($pdo, 'module', $module_id);
}

function addModule($pdo, $module_name) {
    $sql = 'INSERT INTO module (module_name) VALUES (:module_name)';
    $params = [':module_name' => $module_name];
    query($pdo, $sql, $params);
    return $pdo->lastInsertId();
}

function updateModule($pdo, $module_id, $module_name) {
    $sql = 'UPDATE module SET module_name = :module_name WHERE module_id = :id';
    $params = [':module_name' => $module_name, ':id' => $module_id];
    query($pdo, $sql, $params);
}

function deleteModule($pdo, $module_id) {
    // Soft delete: mark module as deleted instead of removing from database
    $sql = 'UPDATE module SET status = \'deleted\' WHERE module_id = :id';
    query($pdo, $sql, [':id' => $module_id]);
}

function restoreModule($pdo, $module_id) {
    $sql = 'UPDATE module SET status = \'active\' WHERE module_id = :id';
    query($pdo, $sql, [':id' => $module_id]);
}
