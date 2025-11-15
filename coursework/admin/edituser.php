<?php
// Moved edituser into admin/ and adjusted includes
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: users.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    updateUser($pdo, $id, $username, $email);
    header('Location: users.php');
    exit;
}

$user = getUser($pdo, $id);
$title = 'Edit user';
ob_start();
?>
<h2>Edit user</h2>
<?php if ($user): ?>
    <form method="post" class="needs-validation">
        <p>
            <label>Username</label>
            <input name="username" value="<?=htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8')?>">
        </p>
        <p>
            <label>Email</label>
            <input name="email" value="<?=htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8')?>">
        </p>
        <p>
            <input type="submit" value="Save">
        </p>
    </form>
<?php else: ?>
    <p>User not found.</p>
<?php endif; ?>
<?php
$output = ob_get_clean();
include '../templates/admin_layout.html.php';
