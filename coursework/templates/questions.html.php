<?php foreach($questions as $question): ?>
    <blockquote>
        <strong><em><?=htmlspecialchars($question['module_name'], ENT_QUOTES, 'UTF-8')?>
        <br></em></strong>
        <?=htmlspecialchars($question['content'], ENT_QUOTES, 'UTF-8')?>
    <!--  
        <img height='100px' src="images/<?=htmlspecialchars($question['image'], 
        ENT_QUOTES, 'UTF-8'); ?>" >
    -->
        (by <a href="mailto:<?=htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8');?>">
        <?=htmlspecialchars($question['username'], ENT_QUOTES, 'UTF-8');?></a>)

        <!-- Edit button -->
        <a href="editquestion.php?id=<?=$question['question_id']?>">Edit</a>
        <!-- Delete Button -->
        <form action="deletequestion.php" method="post">
            <input type="hidden" name="question_id" value="<?=$question['question_id']?>">
            <input type="submit" value="DELETE">
        </form>
    </blockquote>
    <?php endforeach;?>
    
