<?php
try {
    include 'includes/DatabaseConnection.php';
    
    $sql = 'DELETE FROM joke WHERE jokeid = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_POST['jokeid']);
    $stmt->execute();
    header('location: jokes.php');
} catch (PDOException $e) {
    $title = "An error has occured";
    $output = 'Unable to establish Database Connection to delete joke: '
     . $e->getMessage();
}
include 'templates/layout.html.php'
?>
