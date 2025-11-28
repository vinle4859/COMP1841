<?php
include '../includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'ModuleDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

try {
    $module_id = (int) post_or_redirect('module_id', 'modules.php');
    deleteModule($pdo, $module_id);
    header('Location: modules.php');
    exit;
} catch (PDOException $e) {
    $title = "An error has occured";
    $output = 'Database error: ' . $e->getMessage();
}

if (!empty($output)) {
    include ADMIN_TEMPLATES . 'layout.html.php';
}
?>
