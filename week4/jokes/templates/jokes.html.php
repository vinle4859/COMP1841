<!DOCTYPE html>
<html lang="en">
    <head>
        <title>List of Jokes</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <?php if(isset($error)): ?>
            <p> <?=$error ?> </p>
        <?php else:?>
            <table border='1px'>
            <?php foreach($jokes as $joke):?>
                <tr>
                    <td width='300px'>
                    <?=htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8')?>
                    </td>
                    
                    <td width='150px'> 
                    <?php $display_date = date("D d M Y", strtotime($joke['jokedate']))?>
                    <?=htmlspecialchars($display_date, ENT_QUOTES, 'UTF-8')?>
                    </td>

                    <td width='150px'>
                    <img height='100px' src="images/<?=htmlspecialchars(
                        $joke['image'], ENT_QUOTES, 'UTF-8'); ?>" >
                    </td>
                </tr>
                <?php
                endforeach;
                ?>
            </table>
            <?php endif;?>
    </body>
</html>
