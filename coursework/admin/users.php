<?php
// Admin users list and delete (moved into admin/)
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $id = (int)$_POST['delete_user_id'];
    if ($id > 0) {
        deleteUser($pdo, $id);
        header('Location: users.php');
        exit;
    }
}

$users = selectAll($pdo, 'user_account');
$title = 'Admin - Users';
ob_start();
include '../templates/admin_users.html.php';
$output = ob_get_clean();
include '../templates/admin_layout.html.php';
