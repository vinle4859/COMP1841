<?php
session_start();
if ($_SESSION['Authorized'] != "Y") {
    header('Location: Notauthorized.html');
}
?>
