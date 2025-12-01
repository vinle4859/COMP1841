<div class="admin-list">
    <div class="admin-list-header">
        <h2>Users</h2>
        <div>
            <a href="adduser.php" class="admin-action">+ Add user</a>
        </div>
    </div>
    
    <!-- Search Users -->
    <form method="get" class="filter-form admin-filters-horizontal" style="margin-bottom: 1rem;">
        <div class="filter-row">
            <input type="text" name="search" placeholder="Search by username or email..." 
                   value="<?= htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8') ?>" style="min-width: 240px;">
            <button type="submit" class="admin-action">Search</button>
            <?php if (!empty($_GET['search'])): ?>
                <a href="users.php" class="btn-link">Clear</a>
            <?php endif; ?>
        </div>
    </form>
    
    <?php if (empty($users)): ?>
        <div class="empty-state-box">
            <?php if (!empty($searchTerm)): ?>
                <p>No users found matching '<?= htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8') ?>'.</p>
            <?php else: ?>
                <p>No users found.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr class="<?= ($user['status'] ?? 'active') === 'deleted' ? 'row-deleted' : '' ?>">
                <td>
                    <?php if (($user['status'] ?? 'active') === 'deleted'): ?>
                        <span class="deleted-name"><?=htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8')?> [Deleted]</span>
                    <?php else: ?>
                        <?=htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8')?>
                    <?php endif; ?>
                </td>
                <td>
                    <?=htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8')?>
                </td>
                <td>
                    <?php if (($user['status'] ?? 'active') === 'deleted'): ?>
                        <span class="status-badge status-deleted">Deleted</span>
                    <?php else: ?>
                        <span class="status-badge status-active">Active</span>
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <?php if (($user['status'] ?? 'active') === 'deleted'): ?>
                        <form action="restoreuser.php" method="post" style="display:inline;">
                            <?= csrfField() ?>
                            <input type="hidden" name="user_id" value="<?= (int)$user['user_id'] ?>">
                            <input type="submit" value="Restore" class="btn-restore">
                        </form>
                    <?php else: ?>
                        <a href="edituser.php?id=<?= (int)$user['user_id'] ?>" class="btn-link">Edit</a>
                        <?php if ($user['user_id'] !== getCurrentUserId()): ?>
                        <form action="deleteuser.php" method="post" class="confirm-delete">
                            <?= csrfField() ?>
                            <input type="hidden" name="user_id" value="<?= (int)$user['user_id'] ?>">
                            <input type="submit" value="Delete">
                        </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
