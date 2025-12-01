<?php
/**
 * Admin - Archive Module (POST handler)
 * Soft-deletes module. Questions remain but show "[Archived]".
 */
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true, 'csrf' => true]);

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
    include ADMIN_TEMPLATES . 'layout.html.php';
}
