<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?=$title?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= BASE_URL ?>/templates/css/questions.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <div class="header-container">
                <div class="header-spacer"></div>
                <h1>Student Forum</h1>
                <div class="header-auth">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="<?= BASE_URL ?>/profile.php" class="profile-link">Hi, <?= htmlspecialchars($_SESSION['username'] ?? 'User', ENT_QUOTES, 'UTF-8') ?></a>
                        <a href="<?= BASE_URL ?>/auth/logout.php" class="btn-auth">Logout</a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/auth/login.php" class="btn-auth">Login</a>
                        <a href="<?= BASE_URL ?>/auth/signup.php" class="btn-auth btn-signup">Sign Up</a></a></a>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="<?= BASE_URL ?>/index.php" <?= (isset($activePage) && $activePage === 'home') ? 'class="active"' : '' ?>>Home</a></li>
                <li><a href="<?= BASE_URL ?>/questions.php" <?= (isset($activePage) && $activePage === 'questions') ? 'class="active"' : '' ?>>Questions</a></li>
                <li><a href="<?= BASE_URL ?>/addquestion.php" <?= (isset($activePage) && $activePage === 'addquestion') ? 'class="active"' : '' ?>>Ask Question</a></li>
                <li><a href="<?= BASE_URL ?>/contact.php" <?= (isset($activePage) && $activePage === 'contact') ? 'class="active"' : '' ?>>Contact</a></li>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                    <li><a href="<?= BASE_URL ?>/admin/questions.php">Admin</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <main>
            <?php $flash = getFlashMessage(); if ($flash): ?>
            <div class="flash-message flash-<?= htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8') ?>
            </div>
            <?php endif; ?>
            <?=$output?>
        </main>
        <footer>
            <div>&copy; 2025 UOG Student Forum. All rights reserved.</div>
            <div><a href="<?= BASE_URL ?>/terms.php" style="color: #ccc;">Terms of Service</a></div>
        </footer>
        
        <script>
        document.addEventListener('DOMContentLoaded', function(){
            // Confirm deletes for forms with class 'confirm-delete'
            document.querySelectorAll('form.confirm-delete').forEach(function(form){
                form.addEventListener('submit', function(e){
                    if (!confirm('Are you sure you want to delete this item?')) {
                        e.preventDefault();
                    }
                });
            });

            // Simple HTML5-driven client-side validation for forms with .needs-validation
            document.querySelectorAll('form.needs-validation').forEach(function(form){
                form.addEventListener('submit', function(e){
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                        alert('Please complete the required fields before submitting the form.');
                    }
                });
            });

            // Image upload validation - applies to ALL file inputs with type="file" and accept="image/*"
            document.querySelectorAll('input[type="file"][accept*="image"]').forEach(function(fileInput){
                fileInput.closest('form')?.addEventListener('submit', function(e){
                    if (fileInput.files.length > 0) {
                        const file = fileInput.files[0];
                        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        const maxSize = 2 * 1024 * 1024; // 2MB
                        
                        if (!allowedTypes.includes(file.type)) {
                            e.preventDefault();
                            alert('Please select a valid image file (JPG, PNG, or GIF).');
                            fileInput.value = '';
                            return false;
                        }
                        
                        if (file.size > maxSize) {
                            e.preventDefault();
                            alert('File is too large. Maximum size is 2MB.');
                            fileInput.value = '';
                            return false;
                        }
                    }
                });
            });
        });
        </script>
    </body>
</html>
