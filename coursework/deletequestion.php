<?php
try {
    include 'includes/DatabaseConnection.php';
    
    $sql = 'DELETE FROM question WHERE question_id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_POST['question_id']);
    $stmt->execute();
    header('location: questions.php');
} catch (PDOException $e) {
    $title = "An error has occured";
    $output = 'Unable to establish Database Connection to delete question: '
     . $e->getMessage();
}
include 'templates/layout.html.php'
?>
