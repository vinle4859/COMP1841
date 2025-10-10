<?php
try {
    $pdo = new PDO('mysql:host=localhost; dbname=comp1841_week4; charset=utf8mb4',
    'root', '');

    $sql = 'SELECT * FROM `joke`';
    $jokes = $pdo->query($sql);
}
catch (PDOException $e) {
    $error = "Unable to connect to the database server: " . $e; //dev version 1
    // $error = "Unable ..." . $e->getMessage() //dev version 2
    // public version no . $e
}
include 'templates/jokes.html.php'
?>
