<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?=$title?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= BASE_URL ?>/templates/css/questions.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/templates/css/admin.css" rel="stylesheet">
    </head>
    <body>
        <header id="admin">
            <h1>Student Forum - Admin</h1>
            <div class="header-auth">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="user-greeting">Logged in as: <?= htmlspecialchars($_SESSION['username'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></span>
                    <a href="<?= BASE_URL ?>/auth/logout.php" class="btn-auth">Logout</a>
                <?php endif; ?>
            </div>
        </header>

        <div class="admin-container">
            <nav>
                <?php 
                // Get unread message count for nav badge
                $unreadCount = 0;
                if (isset($pdo)) {
                    $unreadQuery = $pdo->query("SELECT COUNT(*) FROM message WHERE status = 'new'");
                    $unreadCount = (int)$unreadQuery->fetchColumn();
                }
                ?>
                <ul>
                    <li><a href="questions.php" <?= (isset($activePage) && $activePage === 'questions') ? 'class="active"' : '' ?>>Question List</a></li>
                    <li><a href="messages.php" <?= (isset($activePage) && $activePage === 'messages') ? 'class="active"' : '' ?>>Inbox<?php if ($unreadCount > 0): ?> (<?= $unreadCount ?> Unread)<?php endif; ?></a></li>
                    <li><a href="users.php" <?= (isset($activePage) && $activePage === 'users') ? 'class="active"' : '' ?>>Users</a></li>
                    <li><a href="modules.php" <?= (isset($activePage) && $activePage === 'modules') ? 'class="active"' : '' ?>>Modules</a></li>
                    <!-- 'Add question' moved to a button at the bottom of the question list -->
                    <li><a href="../index.php">Public Site</a></li>
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
        </div>

        <footer>
            &copy; 2025 UOG Student Forum. All rights reserved.
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
        });
        </script>
    </body>
</html>
