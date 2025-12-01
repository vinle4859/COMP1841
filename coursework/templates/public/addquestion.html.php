<p><a href="questions.php" class="btn-secondary">&larr; Back to Questions</a></p>

<?php if (!empty($error)): ?>
    <div class="errors"><?=htmlspecialchars($error, ENT_QUOTES, 'UTF-8')?></div>
<?php endif; ?>
<?php /* success is not shown here because the controller redirects to the questions list on success */ ?>

<form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    <?= csrfField() ?>
    <p class="required-note"><span class="required">*</span> Required fields</p>
    
    <label for="title">Title <span class="required">*</span></label>
    <input type="text" id="title" name="title" required maxlength="255" value="<?=htmlspecialchars($titleInput ?? '', ENT_QUOTES, 'UTF-8')?>">

    <label for="content">Question <span class="required">*</span></label>
    <textarea id="content" name="content" rows="5" cols="60" required><?=htmlspecialchars($content ?? '', ENT_QUOTES, 'UTF-8')?></textarea>
    
    <label for="module">Module <span class="required">*</span></label>
    <select id="module" name="module" required>
        <option value="">Select a module</option>
        <?php foreach($modules as $m): ?>
            <option value="<?=htmlspecialchars($m['module_id'], ENT_QUOTES, 'UTF-8')?>" <?= (isset($module) && ((string)$module === (string)$m['module_id']) ? 'selected' : '')?>>
            <?=htmlspecialchars($m['module_name'], ENT_QUOTES, 'UTF-8')?></option>
        <?php endforeach; ?>
    </select>

    <!-- User is automatically set from session -->
    <input type="hidden" name="user" value="<?= htmlspecialchars($_SESSION['user_id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    <p class="form-note">Posting as: <strong><?= htmlspecialchars($_SESSION['username'] ?? 'Unknown', ENT_QUOTES, 'UTF-8') ?></strong></p>
    
    <label for="image">Image (optional)</label>
    <input type="file" id="image" name="image" accept="image/*">
    <small style="display: block; margin-top: 0.25rem; color: #666;">Allowed: JPG, PNG, GIF. Max size: 2MB</small>

    <p class="disclaimer" style="background: #fff3cd; padding: 0.75rem; border-radius: 4px; margin: 1rem 0; font-size: 0.9rem;">
        <strong>Reminder:</strong> Do not request assessment solutions or services that would constitute academic misconduct.
    </p>

    <div class="form-actions">
        <input type="submit" name="submit" value="Add" class="btn-primary">
    </div>
</form>
