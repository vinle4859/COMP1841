<form action="" method="post">
    <input type="hidden" name="question_id" value="<?=$question['question_id']?>">
    <label for="content">Edit your question here:</label>
    <textarea name = "content" rows="5" cols="80">
    <?=$question['content']?>
    </textarea>
    <input type="submit" name="submit" value="Save">
    
