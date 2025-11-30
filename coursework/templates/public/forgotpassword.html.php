<div class="auth-container">
    <div class="auth-form-box">
        <h2>Forgot Password</h2>
        
        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
            
            <?php if ($resetLink): ?>
                <div class="demo-notice">
                    <p><strong>Demo Mode:</strong> Click the link below to reset your password:</p>
                    <a href="<?= htmlspecialchars($resetLink, ENT_QUOTES, 'UTF-8') ?>" class="reset-link">
                        <?= htmlspecialchars($resetLink, ENT_QUOTES, 'UTF-8') ?>
                    </a>
                    <p class="demo-note">
                        <em>In future development, this reset email would be sent to your email address.</em>
                    </p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p class="form-description">Enter your email address and we'll send you a password reset email.</p>
            
            <form method="post" class="auth-form">
                <?= csrfField() ?>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required 
                           placeholder="Enter your email address"
                           value="<?= htmlspecialchars($emailValue, ENT_QUOTES, 'UTF-8') ?>">
                </div>
                
                <button type="submit" class="btn-primary btn-full">Send Reset Email</button>
            </form>
        <?php endif; ?>
        
        <div class="auth-links">
            <a href="login.php">← Back to Login</a>
        </div>
    </div>
</div>
