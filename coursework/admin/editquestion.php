<?php
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
try {
    if(isset($_POST['content'])){
        // $sql = 'UPDATE question SET content = :content WHERE question_id = :id';
        // $stmt = $pdo->prepare($sql);
        // $stmt->bindValue(':content', $_POST['content']);
        // $stmt->bindValue(':id', $_POST['question_id']);
        // $stmt->bindValue(':id', $_POST['title']);
        // $stmt->execute();
        if(!empty($_POST['image'])) {
            updateQuestion($pdo, $_POST['question_id'], $_POST['content'], 
            $_POST['title'], $_POST['image'] . ".jpg", $_POST['user'], 
            $_POST['module']);
        } else {
            $question = getQuestion($pdo, $_POST['question_id']);
            updateQuestion($pdo, $_POST['question_id'], $_POST['content'], 
            $_POST['title'], $question['image'], $_POST['user'], 
            $_POST['module']);
        }

        header('location: questions.php');
    }else{
        // $sql = 'SELECT * FROM question WHERE question_id = :id';
        // $stmt = $pdo->prepare($sql);
        // $stmt->bindValue(':id', $_GET['id']);
        // $stmt->execute();
        // $question = $stmt->fetch();
        $question = getQuestion($pdo, $_GET['id']);
        $current_user = getUser($pdo, $question['user_id']);
        $current_module = getModule($pdo, $question['module_id']);
        $title = 'Edit question';
        $users = selectAll($pdo, "user_account");
        $modules = selectAll($pdo, "module");

        ob_start();
        include '../templates/editquestion.html.php';
        $output = ob_get_clean();
    }
} catch(PDOException $e){
    $title = 'Error has occured';
    $output = 'Error editing question: ' . $e->getMessage();
}
include '../templates/admin_layout.html.php';
