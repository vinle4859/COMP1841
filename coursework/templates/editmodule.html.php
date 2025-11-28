<p><a href="modules.php">&larr; Back to Modules</a></p>
<h2>Edit module</h2>

<?php if (!empty($error)): ?>
    <div class="errors"><?=htmlspecialchars($error, ENT_QUOTES, 'UTF-8')?></div>
<?php endif; ?>

<?php if ($module): ?>
    <form method="post" class="needs-validation">
        <input type="hidden" name="module_id" value="<?=htmlspecialchars($module['module_id'], ENT_QUOTES, 'UTF-8')?>">
        <p>
            <label for="module_name">Module name</label>
            <input id="module_name" name="module_name" value="<?=htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8')?>">
        </p>
        <p>
            <input type="submit" value="Save">
        </p>
    </form>
<?php else: ?>
    <p>Module not found.</p>
<?php endif; ?>
