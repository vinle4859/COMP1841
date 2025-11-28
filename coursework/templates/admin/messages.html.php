<div class="admin-list">
    <div class="admin-list-header">
        <h2>Admin Inbox</h2>
    </div>
    
    <table>
        <thead>
            <tr><th>When</th><th>From</th><th>Subject</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php if (empty($messages)): ?>
            <tr><td colspan="5">No messages.</td></tr>
        <?php else: ?>
            <?php foreach ($messages as $message): ?>
                <tr>
                    <td><?=htmlspecialchars(date('d/m/y H:i', strtotime($message['created_at'])), ENT_QUOTES, 'UTF-8')?></td>
                    <td>
                        <?php
                            if (!empty($message['user_id'])) {
                                // registered user
                                $from = trim((string)($message['username'] ?? ''));
                                $em = trim((string)($message['email'] ?? ''));
                            } else {
                                // Guest sender stored on message
                                $from = trim((string)($message['sender_name'] ?? ''));
                                $em = trim((string)($message['sender_email'] ?? ''));
                            }
                        ?>
                        <?=htmlspecialchars($from, ENT_QUOTES, 'UTF-8')?><?php if ($em): ?> <small>(<?=htmlspecialchars($em, ENT_QUOTES, 'UTF-8')?>)</small><?php endif; ?>
                    </td>
                    <td><?=htmlspecialchars($message['subject'], ENT_QUOTES, 'UTF-8')?></td>
                    <td>
                        <?php if ($message['status'] === 'new'): ?>
                            <span class="status-badge status-new">New</span>
                        <?php elseif ($message['status'] === 'resolved'): ?>
                            <span class="status-badge status-resolved">Resolved</span>
                        <?php else: ?>
                            <span class="status-badge"><?=htmlspecialchars($message['status'], ENT_QUOTES, 'UTF-8')?></span>
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <a href="messagedetail.php?id=<?= $message['message_id'] ?>" class="btn-link">View</a>
                        <form action="deletemessage.php" method="post" class="confirm-delete">
                            <input type="hidden" name="message_id" value="<?= (int)$message['message_id'] ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
