<div class="auth-container">
    <div class="auth-form-box">
        <h2>Reset Password</h2>
        
        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
            <div class="auth-links" style="margin-top: 1.5rem;">
                <a href="login.php" class="btn-primary">Go to Login</a>
            </div>
        <?php elseif ($tokenValid): ?>
            <p class="form-description">Enter your new password below.</p>
            
            <form method="post" class="auth-form">
                <?= csrfField() ?>
                <input type="hidden" name="token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">
                
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" required 
                           placeholder="At least 6 characters" minlength="6">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required 
                           placeholder="Re-enter your password">
                </div>
                
                <button type="submit" class="btn-primary btn-full">Reset Password</button>
            </form>
        <?php else: ?>
            <div class="auth-links">
                <a href="forgotpassword.php">Resend reset email</a>
                <span class="divider">|</span>
                <a href="login.php">Back to Login</a>
            </div>
        <?php endif; ?>
    </div>
</div>
