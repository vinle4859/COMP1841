<?php
include '../includes/DataBaseFunctions.php';
if (isset($_POST['content'])) {
    try {
        include '../includes/DatabaseConnection.php';

        // $sql = 'INSERT INTO question SET content = :content, image = :image, 
        // title = :title, user_id = :user_id, module_id = :module_id';
        // $stmt = $pdo->prepare($sql);
        // $stmt->bindValue(':content', $_POST['content']);
        // $stmt->bindValue(':image', strtolower($_POST['image']) . ".jpg");
        // $stmt->bindValue(':title', $_POST['title']);
        // $stmt->bindValue(':module_id', $_POST['module']);
        // $stmt->bindValue(':user_id', $_POST['user']);
        // $stmt->execute();   
        addQuestion($pdo, $_POST['content'], $_POST['image'] . ".jpg", 
        $_POST['title'], $_POST['user'], $_POST['module']);
        header('location: questions.php');
    } catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
    }
} else {
    include '../includes/DatabaseConnection.php';  
    $title = 'Add new question';
    // $sql_users = 'SELECT * FROM user_account';
    // $sql_modules = 'SELECT * FROM module';
    // $users = $pdo->query($sql_users);
    // $modules = $pdo->query($sql_modules);
    $users = selectAll($pdo, "user_account");
    $modules = selectAll($pdo, "module");
    ob_start();
    include '../templates/addquestion.html.php';
    $output = ob_get_clean();
}
include '../templates/admin_layout.html.php';
?>
