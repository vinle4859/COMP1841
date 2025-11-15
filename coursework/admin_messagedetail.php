<?php
// Redirect to new admin messagedetail location
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    header('Location: admin/messagedetail.php?id=' . $id);
} else {
    header('Location: admin/messages.php');
}
exit;
