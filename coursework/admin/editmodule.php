<?php
include '../includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest(['admin' => true]);

include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'ModuleDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

$error = null;

// Get module ID from POST or GET
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $module_id = (int) post_or_redirect('module_id', 'modules.php');
} else {
    $module_id = (int) get_or_redirect('id', 'modules.php');
}

$module = getModule($pdo, $module_id);
if (!$module) {
    header('Location: modules.php');
    exit;
}

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $module_name = trim($_POST['module_name'] ?? '');
        if ($module_name === '') {
            $error = 'Please enter a module name.';
            $module['module_name'] = $module_name;
        } else {
            try {
                updateModule($pdo, $module_id, $module_name);
                header('Location: modules.php');
                exit;
            } catch (PDOException $e) {
                $error = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

// Render page
$title = 'Edit module';
ob_start();
include ADMIN_TEMPLATES . 'editmodule.html.php';
$output = ob_get_clean();
include ADMIN_TEMPLATES . 'layout.html.php';
