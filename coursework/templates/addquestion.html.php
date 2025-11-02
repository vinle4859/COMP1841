<form action="" method="post" class="needs-validation" novalidate>
    <label for="title">Write Your Title:</label>
    <input type="text" id="title" name="title" required maxlength="255">

    <label for="content">Write Your question:</label>
    <textarea id="content" name="content" rows="5" cols="60" required></textarea>
    
    <label for="module">Module</label>
    <select id="module" name="module" required>
        <option value="">Select a module</option>
        <?php foreach($modules as $module): ?>
            <option value="<?=htmlspecialchars($module['module_id'], ENT_QUOTES, 'UTF-8')?>">
            <?=htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8')?></option>
        <?php endforeach; ?>
    </select>

    <label for="user">Author</label>
    <select id="user" name="user" required>
        <option value="">Select a user</option>
        <?php foreach($users as $user): ?>
            <option value="<?=htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8')?>">
            <?=htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8')?></option>
        <?php endforeach; ?>
    </select>
    
    <label for="image">Image (placeholder)</label>
    <input type="text" id="image" name="image" placeholder="image-filename.jpg (optional)">

    <input type="submit" name="Submit" value="Add">
</form>
