<div class="admin-list">
    <div class="admin-list-header">
        <h2>Modules</h2>
    </div>
    
    <?php if (!empty($error)): ?>
        <div class="error-message"><?=htmlspecialchars($error, ENT_QUOTES, 'UTF-8')?></div>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
        <div class="success-message"><?=htmlspecialchars($success, ENT_QUOTES, 'UTF-8')?></div>
    <?php endif; ?>
    
    <form action="addmodule.php" method="post" class="inline-add-form">
        <?= csrfField() ?>
        <label for="module_name">Add New Module<span class="required">*</span></label>
        <div class="inline-add-row">
            <input type="text" id="module_name" name="module_name" placeholder="Enter module name" required maxlength="255">
            <input type="submit" value="+ Add" class="admin-action">
        </div>
    </form>
    
    <?php if (empty($modules)): ?>
        <div class="empty-state-box">
            <p>Add a module.</p>
        </div>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Module Code</th>
                <th>Module Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($modules as $module): ?>
            <tr class="<?= ($module['status'] ?? 'active') === 'deleted' ? 'row-deleted' : '' ?>">
                <td><?=htmlspecialchars($module['module_id'], ENT_QUOTES, 'UTF-8')?></td>
                <td>
                    <?php if (($module['status'] ?? 'active') === 'deleted'): ?>
                        <span class="deleted-name"><?=htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8')?> [Archived]</span>
                    <?php else: ?>
                        <?=htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8')?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (($module['status'] ?? 'active') === 'deleted'): ?>
                        <span class="status-badge status-archived">Archived</span>
                    <?php else: ?>
                        <span class="status-badge status-active">Active</span>
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <?php if (($module['status'] ?? 'active') === 'deleted'): ?>
                        <form action="restoremodule.php" method="post" style="display:inline;">
                            <?= csrfField() ?>
                            <input type="hidden" name="module_id" value="<?= (int)$module['module_id'] ?>">
                            <input type="submit" value="Restore" class="btn-restore">
                        </form>
                    <?php else: ?>
                        <a href="editmodule.php?id=<?= (int)$module['module_id'] ?>" class="btn-link">Edit</a>
                        <form action="deletemodule.php" method="post" class="confirm-delete">
                            <?= csrfField() ?>
                            <input type="hidden" name="module_id" value="<?= (int)$module['module_id'] ?>">
                            <input type="submit" value="Archive">
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
