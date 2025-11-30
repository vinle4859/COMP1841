<p><a href="questiondetail.php?id=<?= $question['question_id'] ?>" class="btn-secondary">&larr; Back to Question</a></p>

<?php if (!empty($error)): ?>
    <div class="errors"><?=htmlspecialchars($error, ENT_QUOTES, 'UTF-8')?></div>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    <?= csrfField() ?>
    <input type="hidden" name="question_id" value="<?= $question['question_id'] ?>">
    
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required maxlength="255" value="<?=htmlspecialchars($question['title'] ?? '', ENT_QUOTES, 'UTF-8')?>">

    <label for="content">Question Content:</label>
    <textarea id="content" name="content" rows="5" cols="60" required><?=htmlspecialchars($question['content'] ?? '', ENT_QUOTES, 'UTF-8')?></textarea>
    
    <p class="form-note">Module: <strong><?=htmlspecialchars($moduleName ?? 'Unknown', ENT_QUOTES, 'UTF-8')?></strong>
    <br><small>Contact an administrator if you need to change the module.</small></p>

    <?php if (!empty($question['image'])): ?>
    <div class="current-image">
        <label>Current Image:</label>
        <img src="images/<?=htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8')?>" alt="Current question image" style="max-height: 150px; display: block; margin: 0.5rem 0;">
    </div>
    <?php endif; ?>
    
    <label for="image">Replace Image (optional)</label>
    <input type="file" id="image" name="image" accept="image/*">
    <small style="display: block; margin-top: 0.25rem; color: #666;">Allowed: JPG, PNG, GIF. Max size: 2MB. Leave empty to keep current image.</small>

    <div class="form-actions">
        <input type="submit" name="submit" value="Save Changes" class="btn-primary">
        <a href="questiondetail.php?id=<?= $question['question_id'] ?>" class="btn-secondary">Cancel</a>
    </div>
</form>
