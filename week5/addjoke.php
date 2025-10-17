<?php
if (isset($_POST['joketext'])) {
    try {
        include 'includes/DatabaseConnection.php';

        $sql = 'INSERT INTO joke SET joketext = :joketext, jokedate = CURDATE(),
         image = :image';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':joketext', $_POST['joketext']);
        $stmt->bindValue(':image', strtolower($_POST['image']) . ".jpg");
        $stmt->execute();   
        header('location: jokes.php');
    } catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
    }
} else {
    $title = 'Add new joke';
    ob_start();
    include 'templates/addjoke.html.php';
    $output = ob_get_clean();
}
include 'templates/layout.html.php';
?>
