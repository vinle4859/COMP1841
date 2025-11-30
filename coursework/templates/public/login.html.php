<div class="auth-container">
    <div class="auth-card">
        <h2>Login</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        
        <form method="post" action="" class="auth-form needs-validation">
            <?= csrfField() ?>
            <div class="form-group">
                <label for="login">Username or Email</label>
                <input type="text" id="login" name="login" 
                       value="<?= htmlspecialchars($_POST['login'] ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                       required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group forgot-password-link">
                <a href="forgotpassword.php">Forgot your password?</a>
            </div>
            
            <button type="submit" class="btn-primary btn-full">Login</button>
        </form>
        
        <div class="auth-links">
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </div>
</div>
