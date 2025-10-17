<?php foreach($jokes as $joke): ?>
    <blockquote>
        <?=htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8')?>
        <img height='100px' src="images/<?=htmlspecialchars($joke['image'], 
        ENT_QUOTES, 'UTF-8'); ?>" >
        <form action="deletejoke.php" method="post">
            <input type="hidden" name="jokeid" value="<?=$joke['jokeid']?>">
            <input type="submit" value="DELETE">
        </form>
    </blockquote>
    <?php endforeach;?>
