<?php
include '../includes/config.php';
include INCLUDES_PATH . 'DatabaseConnection.php';
include FUNCTIONS_PATH . 'DatabaseFunctions.php';
include FUNCTIONS_PATH . 'ModuleDbFunctions.php';
include INCLUDES_PATH . 'InputHelpers.php';

$error = null;
try {
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $module_name = trim($_POST['module_name'] ?? '');
        if ($module_name === '') {
            $error = 'Please enter a module name.';
            $module['module_name'] = $module_name;
        } else {
            updateModule($pdo, $module_id, $module_name);
            header('Location: modules.php');
            exit;
        }
    }

    $title = 'Edit module';
    ob_start();
    include ADMIN_TEMPLATES . 'editmodule.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include ADMIN_TEMPLATES . 'layout.html.php';
