<?php
$ActualPassword = 'Admin123';
$ActualUsername = 'Admin';
if (($_POST['username'] == $ActualUsername) 
    && ($_POST['password'] == $ActualPassword)) {
    session_start();
    $_SESSION['Authorized'] = "Y";
    header("Location: index.php");
} else {
    header('Location: Wrongpassword.php');
    exit;
}
?>
