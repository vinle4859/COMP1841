<?php
/**
 * Database Connection
 * Creates PDO instance for MySQL. Update credentials for production.
 */
$pdo = new PDO('mysql:host=localhost; dbname=comp1841_coursework; charset=utf8mb4',
 'root', '');
?>
