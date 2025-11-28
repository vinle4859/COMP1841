<?php
/**
 * Core Database Functions
 * Generic query helper and shared utilities.
 */

function query($pdo, $sql, $parameters = []) {
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
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

function selectAll($pdo, $table, $includeDeleted = false) {
    $tables = ['user_account', 'module'];

    if (!in_array($table, $tables)) {
        throw new \Exception("Invalid table name.");
    }
    
    if ($includeDeleted) {
        $sql = "SELECT * FROM $table ORDER BY status ASC";
    } else {
        $sql = "SELECT * FROM $table WHERE status = 'active'";
    }
    $data = query($pdo, $sql);
    return $data->fetchAll();
}
