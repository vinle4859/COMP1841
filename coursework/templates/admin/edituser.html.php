<p><a href="users.php">&larr; Back to Users</a></p>
<h2>Edit user</h2>

<?php if (!empty($error)): ?>
    <div class="errors"><?=htmlspecialchars($error, ENT_QUOTES, 'UTF-8')?></div>
<?php endif; ?>

<?php if ($user): ?>
    <form method="post" class="needs-validation">
        <?= csrfField() ?>
        <input type="hidden" name="user_id" value="<?=htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8')?>">
        <p>
            <label for="username">Username<span class="required">*</span></label>
            <input id="username" name="username" required value="<?=htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8')?>">
        </p>
        <p>
            <label for="email">Email<span class="required">*</span></label>
            <input id="email" name="email" required value="<?=htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8')?>">
        </p>
        <p>
            <input type="submit" value="Save">
        </p>
    </form>
<?php else: ?>
    <p>User not found.</p>
<?php endif; ?>
