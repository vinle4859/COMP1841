<p><a href="users.php">&larr; Back to Users</a></p>

<h2>Add user</h2>

<?php if (!empty($error)): ?>
    <div class="errors"><?=htmlspecialchars($error, ENT_QUOTES, 'UTF-8')?></div>
<?php endif; ?>

<form method="post" class="needs-validation">
    <p>
        <label for="username">Username</label>
        <input id="username" name="username" required maxlength="255" value="<?=htmlspecialchars($username ?? '', ENT_QUOTES, 'UTF-8')?>">
    </p>
    <p>
        <label for="email">Email</label>
        <input id="email" name="email" required maxlength="255" value="<?=htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8')?>">
    </p>
    <p>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required placeholder="Enter your password">
    </p>
    <p>
        <input type="submit" value="Add user">
    </p>
</form>
