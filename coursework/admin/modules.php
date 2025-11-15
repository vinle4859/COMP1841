<?php
// Admin modules list and delete (moved into admin/)
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_module_id'])) {
    $id = (int)$_POST['delete_module_id'];
    if ($id > 0) {
        deleteModule($pdo, $id);
        header('Location: modules.php');
        exit;
    }
}

$modules = selectAll($pdo, 'module');
$title = 'Admin - Modules';
ob_start();
include '../templates/admin_modules.html.php';
$output = ob_get_clean();
include '../templates/admin_layout.html.php';
