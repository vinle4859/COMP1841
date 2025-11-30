<?php
/**
 * Not Authorized Page
 * Shown when a user tries to access a page they don't have permission for.
 */

require_once dirname(__DIR__) . '/includes/config.php';
require_once FUNCTIONS_PATH . 'SessionFunctions.php';
initSession();

$title = 'Access Denied - Student Forum';
$activePage = '';

ob_start();
?>
<div class="auth-container">
    <div class="auth-card">
        <h2>Access Denied</h2>
        <div class="error-message">
            You do not have permission to access this page.
        </div>
        <p>This area is restricted to administrators only.</p>
        <div class="auth-links">
            <?php if (isLoggedIn()): ?>
                <p>You are logged in as <strong><?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></strong></p>
                <p><a href="<?= BASE_URL ?>/index.php">Return to Home</a></p>
            <?php else: ?>
                <p><a href="<?= BASE_URL ?>/auth/login.php">Login with a different account</a></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
$output = ob_get_clean();

include PUBLIC_TEMPLATES . 'layout.html.php';
