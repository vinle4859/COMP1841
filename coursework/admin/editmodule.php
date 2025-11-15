<?php
// Moved editmodule into admin/ and adjusted includes
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: modules.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $module_name = isset($_POST['module_name']) ? trim($_POST['module_name']) : '';
    updateModule($pdo, $id, $module_name);
    header('Location: modules.php');
    exit;
}

$module = getModule($pdo, $id);
$title = 'Edit module';
ob_start();
?>
<h2>Edit module</h2>
<?php if ($module): ?>
    <form method="post" class="needs-validation">
        <p>
            <label>Module name</label>
            <input name="module_name" value="<?=htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8')?>">
        </p>
        <p>
            <input type="submit" value="Save">
        </p>
    </form>
<?php else: ?>
    <p>Module not found.</p>
<?php endif; ?>
<?php
$output = ob_get_clean();
include '../templates/admin_layout.html.php';
