<?php
// Restore a soft-deleted module
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['module_id'])) {
    $module_id = (int) $_POST['module_id'];
    restoreModule($pdo, $module_id);
}

header('Location: modules.php');
exit;
