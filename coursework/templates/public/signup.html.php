<div class="auth-container">
    <div class="auth-card">
        <h2>Create Account</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        
        <form method="post" action="" class="auth-form needs-validation">
            <?= csrfField() ?>
            <p class="required-note"><span class="required">*</span> Required fields</p>
            
            <div class="form-group">
                <label for="username">Username <span class="required">*</span></label>
                <input type="text" id="username" name="username" 
                       value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                       required minlength="3" maxlength="50" autofocus>
                <small>3-50 characters</small>
            </div>
            
            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" 
                       value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="password">Password <span class="required">*</span></label>
                <input type="password" id="password" name="password" required minlength="6">
                <small>At least 6 characters</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password <span class="required">*</span></label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <div class="form-group form-checkbox">
                <input type="checkbox" name="agree_terms" id="agree_terms" required>
                <label for="agree_terms">
                    I agree to the <a href="<?= BASE_URL ?>/terms.php" target="_blank">Terms of Service</a>
                </label>
            </div>
            
            <button type="submit" class="btn-primary btn-full">Create Account</button>
        </form>
        
        <div class="auth-links">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</div>
