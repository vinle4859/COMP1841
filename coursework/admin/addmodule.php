<?php
// Handler for adding modules - POST only, redirects back to modules.php
include '../includes/DatabaseFunctions.php';
include '../includes/DatabaseConnection.php';

// Only handle POST requests
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
