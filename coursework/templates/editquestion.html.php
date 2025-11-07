<form action="" method="post" class="needs-validation" novalidate>
    <input type="hidden" name="question_id" value="<?=htmlspecialchars($question['question_id'], ENT_QUOTES, 'UTF-8')?>">
    <!-- Edit Title -->
    <label for="title">Edit your question title:</label>
    <input type="text" id="title" name="title" value="<?=htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8')?>" required maxlength="255">

    <!-- Edit Content -->
    <label for="content">Edit your question content:</label>
    <textarea id="content" name="content" rows="5" cols="80" required><?=htmlspecialchars($question['content'], ENT_QUOTES, 'UTF-8')?>
    </textarea>

    <!-- Edit Image -->
    <p>
        <label for="current-image">Current Image:</label>
        <?php if (!empty($question['image'])): ?>
            <img id="current-image" src="../images/<?=htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8')?>" alt="Current image" style="vertical-align:middle; height:100px; margin-left:10px;">
        <?php else: ?>
            <em>No image</em>
        <?php endif; ?>
    </p>

    <br>

    <label for="image">New Image:</label>
    <input type="text" id="image" name="image" placeholder="image-filename.jpg (optional)">

    <br>

        <label for="module">Module</label>
    <select id="module" name="module" required>
        <option value="<?=htmlspecialchars($current_module['module_id'], ENT_QUOTES, 'UTF-8')?>">
            Current: <?=htmlspecialchars($current_module['module_name'], ENT_QUOTES, 'UTF-8')?></option>
        <?php foreach($modules as $module): ?>
            <option value="<?=htmlspecialchars($module['module_id'], ENT_QUOTES, 'UTF-8')?>">
            <?=htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8')?></option>
        <?php endforeach; ?>
    </select>
    
    <br>

    <label for="user">Author</label>
    <select id="user" name="user" required>
        <option value="<?=htmlspecialchars($current_user['user_id'], ENT_QUOTES, 'UTF-8')?>">
            Current: <?=htmlspecialchars($current_user['username'], ENT_QUOTES, 'UTF-8')?></option>
        <?php foreach($users as $user): ?>
            <option value="<?=htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8')?>">
            <?=htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8')?></option>
        <?php endforeach; ?>
    </select>

    <br>

    <!-- Save Button -->
    <input type="submit" name="submit" value="Save">           
</form>
