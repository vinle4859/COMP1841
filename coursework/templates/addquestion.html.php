<form action="", method="post">
    <label for="title">Write Your Title:</label>
    <textarea rows="3" cols="30" name="title"></textarea>

    <label for="content">Write Your question:</label>
    <textarea rows="3" cols="40" name="content"></textarea>
    
    <select name="module">
        <option value="">Select a module</option>
        <?php foreach($modules as $module): ?>
            <option value="<?=htmlspecialchars($module['module_id'], ENT_QUOTES, 'UTF-8')?>">
            <?=htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8')?></option>
        <?php endforeach; ?>
    </select>

    <select name="user">
        <option value="">Select a user</option>
        <?php foreach($users as $user): ?>
            <option value="<?=htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8')?>">
            <?=htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8')?></option>
        <?php endforeach; ?>
    </select>
    
    <label for="image">Input Your Image:</label>
    <textarea rows="3" cols="20" name="image"></textarea>

    <input type="submit" name="Submit" value="Add">
</form>
