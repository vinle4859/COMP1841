<p><a href="questions.php">&larr; Back to Questions</a></p>
<form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    <?= csrfField() ?>
    <input type="hidden" name="question_id" value="<?=htmlspecialchars($question['question_id'], ENT_QUOTES, 'UTF-8')?>">
    
    <p class="required-note"><span class="required">*</span> Required fields</p>
    
    <!-- Edit Title -->
    <label for="title">Edit your question title:<span class="required">*</span></label>
    <input type="text" id="title" name="title" value="<?=htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8')?>" required maxlength="255">

    <!-- Edit Content -->
    <label for="content">Edit your question content:<span class="required">*</span></label>
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

    <label for="image">Upload New Image:</label>
    <input type="file" id="image" name="image" accept="image/*">
    <small style="display: block; margin-top: 0.25rem; color: #666;\">Allowed: JPG, PNG, GIF. Max size: 2MB. Leave empty to keep current image.</small>

    <br>

    <label for="module">Module<span class="required">*</span></label>
    <select id="module" name="module" required>
        <option value="<?=htmlspecialchars($current_module['module_id'], ENT_QUOTES, 'UTF-8')?>">
            Current: <?=htmlspecialchars($current_module['module_name'], ENT_QUOTES, 'UTF-8')?><?= ($current_module['status'] ?? '') === 'deleted' ? ' [Archived]' : '' ?></option>
        <?php foreach($modules as $module): ?>
            <?php if ($module['module_id'] != $current_module['module_id']): ?>
            <option value="<?=htmlspecialchars($module['module_id'], ENT_QUOTES, 'UTF-8')?>" <?= ($module['status'] ?? '') === 'deleted' ? 'disabled' : '' ?>>
            <?=htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8')?><?= ($module['status'] ?? '') === 'deleted' ? ' [Archived]' : '' ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
    
    <br>

    <label for="user">Author<span class="required">*</span></label>
    <select id="user" name="user" required>
        <option value="<?=htmlspecialchars($current_user['user_id'], ENT_QUOTES, 'UTF-8')?>">
            Current: <?=htmlspecialchars($current_user['username'], ENT_QUOTES, 'UTF-8')?><?= ($current_user['status'] ?? '') === 'deleted' ? ' [Deleted]' : '' ?></option>
        <?php foreach($users as $user): ?>
            <?php if ($user['user_id'] != $current_user['user_id']): ?>
            <option value="<?=htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8')?>" <?= ($user['status'] ?? '') === 'deleted' ? 'disabled' : '' ?>>
            <?=htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8')?><?= ($user['status'] ?? '') === 'deleted' ? ' [Deleted]' : '' ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>

    <br>

    <!-- Save Button -->
    <input type="submit" name="submit" value="Save">
</form>
