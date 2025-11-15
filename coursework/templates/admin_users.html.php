<div class="admin-list">
    <h2>Users</h2>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?=htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8')?></td>
                <td><?=htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8')?></td>
                <td>
                    <a href="edituser.php?id=<?= (int)$user['user_id'] ?>">Edit</a>
                    <form action="users.php" method="post" class="confirm-delete" style="display:inline-block; margin-left:0.5rem;">
                        <input type="hidden" name="delete_user_id" value="<?= (int)$user['user_id'] ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
