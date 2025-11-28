<?php
try {
    include '../includes/DatabaseConnection.php';
    include '../includes/DatabaseFunctions.php';
    include '../includes/InputHelpers.php';
    $module_id = (int) post_or_redirect('module_id', 'modules.php');
    deleteModule($pdo, $module_id);
    header('Location: modules.php');
    exit;
} catch (PDOException $e) {
    $title = "An error has occured";
    $output = 'Database error: ' . $e->getMessage();
}

if (!empty($output)) {
    include '../templates/admin_layout.html.php';
}
?>
