<?php
try {
    include 'includes/DatabaseConnection.php';
    include 'includes/DatabaseFunctions.php';
    // $sql = 'DELETE FROM question WHERE question_id = :id';
    // $stmt = $pdo->prepare($sql);
    // $stmt->bindValue(':id', $_POST['question_id']);
    // $stmt->execute();
    deleteQuestion($pdo, $_POST['question_id']);
    header('location: questions.php');
} catch (PDOException $e) {
    $title = "An error has occured";
    $output = 'Unable to establish Database Connection to delete question: '
     . $e->getMessage();
}
include 'templates/layout.html.php'
?>
