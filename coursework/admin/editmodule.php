<?php
// Moved editmodule into admin/ and adjusted includes
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
include '../includes/InputHelpers.php';

// Unified flow: POST uses `module_id`, GET uses `id`. Single layout include at end.
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
            // preserve submitted value
            $module['module_name'] = $module_name;
        } else {
            updateModule($pdo, $module_id, $module_name);
            header('Location: modules.php');
            exit;
        }
    }

    $title = 'Edit module';
    ob_start();
    include '../templates/editmodule.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include '../templates/admin_layout.html.php';
