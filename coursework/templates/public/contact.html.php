<h2>Contact Admin</h2>

<?php if (!empty($error)): ?>
    <div class="errors"><?=htmlspecialchars($error, ENT_QUOTES, 'UTF-8')?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="success"><?=htmlspecialchars($success, ENT_QUOTES, 'UTF-8')?></div>
<?php endif; ?>

<?php if (isLoggedIn()): ?>
    <p class="form-note">Sending as: <strong><?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></strong> (<?= htmlspecialchars($_SESSION['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>)</p>
<?php endif; ?>

<form action="contact.php" method="post" class="needs-validation" novalidate>
    <?= csrfField() ?>
    <p class="required-note"><span class="required">*</span> Required fields</p>
    
    <?php if (isLoggedIn()): ?>
        <!-- Hidden fields for logged-in users -->
        <input type="hidden" name="name" value="<?=htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8')?>">
        <input type="hidden" name="email" value="<?=htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8')?>">
    <?php else: ?>
        <!-- Visible fields for guests -->
        <label for="name">Your Name <span class="required">*</span></label>
        <input id="name" name="name" required maxlength="100" value="<?=htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8')?>">

        <label for="email">Your Email <span class="required">*</span></label>
        <input id="email" name="email" type="email" required value="<?=htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8')?>">
    <?php endif; ?>

    <label for="subject">Subject <span class="required">*</span></label>
    <input id="subject" name="subject" required maxlength="255" value="<?=htmlspecialchars($subject ?? '', ENT_QUOTES, 'UTF-8')?>">

    <label for="body">Message <span class="required">*</span></label>
    <textarea id="body" name="body" rows="6" required><?=htmlspecialchars($body ?? '', ENT_QUOTES, 'UTF-8')?></textarea>

    <input type="submit" name="submit" value="Send">
</form>

<?php /* auto-hide script removed */ ?>
