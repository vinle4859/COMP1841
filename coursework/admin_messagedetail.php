<?php
// Redirect to new admin messagedetail location (simple demo-style)
$id = $_GET['id'];
if ($id) {
    header('Location: admin/messagedetail.php?id=' . $id);
    exit;
} else {
    header('Location: admin/messages.php');
}
exit;
