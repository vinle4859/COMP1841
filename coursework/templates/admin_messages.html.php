<h2>Admin Inbox</h2>
<p>Note: This page is not protected by authentication in the current prototype.</p>
<table>
    <thead>
        <tr><th>When</th><th>From</th><th>Subject</th><th>Status</th><th></th></tr>
    </thead>
    <tbody>
    <?php if (empty($messages)): ?>
        <tr><td colspan="5">No messages.</td></tr>
    <?php else: ?>
        <?php foreach ($messages as $message): ?>
            <tr>
                <td><?=htmlspecialchars($message['created_at'], ENT_QUOTES, 'UTF-8')?></td>
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
                    <?=htmlspecialchars($from, ENT_QUOTES, 'UTF-8')?><?php if ($em): ?> (<?=htmlspecialchars($em, ENT_QUOTES, 'UTF-8')?>)<?php endif; ?>
                </td>
                <td><?=htmlspecialchars($message['subject'], ENT_QUOTES, 'UTF-8')?></td>
                <td><?=htmlspecialchars($message['status'], ENT_QUOTES, 'UTF-8')?></td>
                <td><a href="admin_message.php?id=<?= $message['message_id'] ?>">View</a></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
