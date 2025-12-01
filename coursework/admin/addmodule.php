<?php
/**
 * Admin - Add Module (POST handler)
 * Creates new course module, redirects to modules list.
 */
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true, 'csrf' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'ModuleDbFunctions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: modules.php');
    exit;
}

$module_name = trim($_POST['module_name'] ?? '');

if ($module_name === '') {
    header('Location: modules.php?error=' . urlencode('Please enter a module name.'));
    exit;
}

try {
    addModule($pdo, $module_name);
    header('Location: modules.php?success=' . urlencode('Module added successfully!'));
    exit;
} catch (PDOException $e) {
    header('Location: modules.php?error=' . urlencode('Failed to add module.'));
    exit;
}
