<?php
if (isset($_POST['content'])) {
    try {
        include 'includes/DatabaseConnection.php';

        $sql = 'INSERT INTO question SET content = :content, image = :image, 
        title = :title, user_id = :user_id, module_id = :module_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':content', $_POST['content']);
        $stmt->bindValue(':image', strtolower($_POST['image']) . ".jpg");
        $stmt->bindValue(':title', $_POST['title']);
        $stmt->bindValue(':module_id', $_POST['module_id']);
        $stmt->bindValue(':user_id', $_POST['user_id']);
        $stmt->execute();   
        header('location: questions.php');
    } catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
    }
} else {
    $title = 'Add new question';
    ob_start();
    include 'templates/addquestion.html.php';
    $output = ob_get_clean();
}
include 'templates/layout.html.php';
?>
