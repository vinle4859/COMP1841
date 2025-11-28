<a href="questiondetail.php?id=<?=$answer['question_id']?>">&larr; Back to Question</a>

<h2>Edit Answer</h2>

<div class="answer" style="margin-bottom: 1.5rem; background: #f5f5f5; padding: 1rem; border-radius: 6px;">
    <p><strong>Question:</strong> <?=htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8')?></p>
    <p><strong>Original Posted:</strong> <?=htmlspecialchars(date('d/m/Y H:i', strtotime($answer['created_at'])), ENT_QUOTES, 'UTF-8')?></p>
</div>

<?php if (!empty($error)): ?>
    <div class="error-message"><?=htmlspecialchars($error, ENT_QUOTES, 'UTF-8')?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <p>
        <label for="content">Answer Content:</label>
        <textarea name="content" id="content" rows="6" required><?=htmlspecialchars($content, ENT_QUOTES, 'UTF-8')?></textarea>
    </p>
    
    <?php if (!empty($answer['image'])): ?>
        <p>
            <label>Current Image:</label>
            <img src="../images/<?=htmlspecialchars($answer['image'], ENT_QUOTES, 'UTF-8')?>" alt="Current answer image" style="max-height: 150px; display: block; margin-top: 0.5rem;">
        </p>
    <?php endif; ?>
    
    <p>
        <label for="image">Replace Image (optional):</label>
        <input type="file" name="image" id="image" accept="image/*">
        <small style="display: block; margin-top: 0.25rem; color: #666;">Allowed: JPG, PNG, GIF. Max size: 2MB</small>
    </p>
    
    <div class="form-actions">
        <input type="submit" value="Save Changes" class="admin-action">
        <a href="questiondetail.php?id=<?=$answer['question_id']?>" class="btn-link">Cancel</a>
    </div>
</form>
