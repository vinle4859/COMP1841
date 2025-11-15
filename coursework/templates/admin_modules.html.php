<div class="admin-list">
    <h2>Modules</h2>
    <table>
        <thead>
            <tr>
                <th>Module Code</th>
                <th>Module Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($modules as $module): ?>
            <tr>
                <td><?=htmlspecialchars($module['module_id'], ENT_QUOTES, 'UTF-8')?></td>
                <td><?=htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8')?></td>
                <td>
                    <a href="editmodule.php?id=<?= (int)$module['module_id'] ?>">Edit</a>
                    <form action="modules.php" method="post" class="confirm-delete" style="display:inline-block; margin-left:0.5rem;">
                        <input type="hidden" name="delete_module_id" value="<?= (int)$module['module_id'] ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
