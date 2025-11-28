<p><a href="questions.php" class="btn-secondary">&larr; Back to Questions</a></p>

<?php if (!empty($error)): ?>
    <div class="errors"><?=htmlspecialchars($error, ENT_QUOTES, 'UTF-8')?></div>
<?php endif; ?>
<?php /* success is not shown here because the controller redirects to the questions list on success */ ?>

<form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    <label for="title">Write Your Title:</label>
    <input type="text" id="title" name="title" required maxlength="255" value="<?=htmlspecialchars($titleInput ?? '', ENT_QUOTES, 'UTF-8')?>">

    <label for="content">Write Your question:</label>
    <textarea id="content" name="content" rows="5" cols="60" required><?=htmlspecialchars($content ?? '', ENT_QUOTES, 'UTF-8')?></textarea>
    
    <label for="module">Module</label>
    <select id="module" name="module" required>
        <option value="">Select a module</option>
        <?php foreach($modules as $m): ?>
            <option value="<?=htmlspecialchars($m['module_id'], ENT_QUOTES, 'UTF-8')?>" <?= (isset($module) && ((string)$module === (string)$m['module_id']) ? 'selected' : '')?>>
            <?=htmlspecialchars($m['module_name'], ENT_QUOTES, 'UTF-8')?></option>
        <?php endforeach; ?>
    </select>

    <label for="user">Author</label>
    <select id="user" name="user" required>
        <option value="">Select a user</option>
        <?php foreach($users as $u): ?>
            <option value="<?=htmlspecialchars($u['user_id'], ENT_QUOTES, 'UTF-8')?>" <?= (isset($user) && ((string)$user === (string)$u['user_id']) ? 'selected' : '')?> >
            <?=htmlspecialchars($u['username'], ENT_QUOTES, 'UTF-8')?></option>
        <?php endforeach; ?>
    </select>
    
    <label for="image">Image (optional)</label>
    <input type="file" id="image" name="image" accept="image/*">
    <small style="display: block; margin-top: 0.25rem; color: #666;">Allowed: JPG, PNG, GIF. Max size: 2MB</small>

    <div class="form-actions">
        <input type="submit" name="submit" value="Add" class="btn-primary">
    </div>
</form>
