<h2>Contact Admin</h2>

<?php if (!empty($error)): ?>
    <div class="errors"><?=htmlspecialchars($error, ENT_QUOTES, 'UTF-8')?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <br>
    <div class="success"><?=htmlspecialchars($success, ENT_QUOTES, 'UTF-8')?></div>
<?php endif; ?>

<br>

<form action="contact.php" method="post" class="needs-validation" novalidate>
    <label for="name">Name</label>
    <input id="name" name="name" required maxlength="100" value="<?=htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8')?>">

    <label for="email">Email</label>
    <input id="email" name="email" type="email" required value="<?=htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8')?>">

    <label for="subject">Subject</label>
    <input id="subject" name="subject" required maxlength="255" value="<?=htmlspecialchars($subject ?? '', ENT_QUOTES, 'UTF-8')?>">

    <label for="body">Message</label>
    <textarea id="body" name="body" rows="6" required><?=htmlspecialchars($body ?? '', ENT_QUOTES, 'UTF-8')?></textarea>

    <input type="submit" name="submit" value="Send">
</form>

<?php /* auto-hide script removed */ ?>
