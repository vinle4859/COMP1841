<div class="admin-list">
    <div class="admin-list-header">
        <h2>Admin Inbox</h2>
        <?php $showUnreadOnly = isset($_GET['unread']) && $_GET['unread'] === '1'; ?>
        <?php if ($totalUnreadCount > 0 || $showUnreadOnly): ?>
        <div class="filter-toggle">
            <?php if ($showUnreadOnly): ?>
                <a href="messages.php" class="btn-filter">Show All</a>
            <?php else: ?>
                <a href="messages.php?unread=1" class="btn-filter">Show Unread Only (<?= $totalUnreadCount ?>)</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <?php if (empty($messages)): ?>
        <div class="empty-state-box">
            <?php if ($showUnreadOnly): ?>
                <p>No unread messages. <a href="messages.php">Show all messages</a></p>
            <?php else: ?>
                <p>No messages in inbox. Messages from users will appear here.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
    <table>
        <thead>
            <tr><th>When</th><th>From</th><th>Subject</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $message): ?>
                <tr class="<?= $message['status'] === 'new' ? 'row-unread' : '' ?>">
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
                            <span class="status-badge status-new">Unread</span>
                        <?php else: ?>
                            <span class="status-badge status-read">Read</span>
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <a href="messagedetail.php?id=<?= $message['message_id'] ?>" class="btn-link">View</a>
                        <form action="deletemessage.php" method="post" class="confirm-delete">
                            <?= csrfField() ?>
                            <input type="hidden" name="message_id" value="<?= (int)$message['message_id'] ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
