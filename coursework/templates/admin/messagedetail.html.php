<div class="message-detail-header">
    <div>
        <p><a href="messages.php">&larr; Back to Messages</a></p>
        <h2>Message #<?= (int)$message['message_id'] ?></h2>
    </div>
    <div class="message-status-control">
        <?php if ($message['status'] === 'read'): ?>
        <form action="messagedetail.php?id=<?= (int)$message['message_id'] ?>" method="post" class="inline-form">
            <?= csrfField() ?>
            <input type="hidden" name="status" value="new">
            <button type="submit" class="btn btn-secondary">Mark as Unread</button>
        </form>
        <?php endif; ?>
    </div>
</div>

<div class="message-detail-body">
    <p><strong>From:</strong> <?= htmlspecialchars($message['sender_name'] ?? 'Anonymous', ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($message['sender_email'] ?? 'Not provided', ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Received:</strong> <?= htmlspecialchars(date('M j, Y \a\t g:i A', strtotime($message['created_at'])), ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Subject:</strong> <?= htmlspecialchars($message['subject'], ENT_QUOTES, 'UTF-8') ?></p>
    <hr>
    <div class="message-content-text"><?= nl2br(htmlspecialchars($message['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?></div>
    <hr>
    <form action="deletemessage.php" method="post" class="confirm-delete inline-form">
        <?= csrfField() ?>
        <input type="hidden" name="message_id" value="<?= (int)$message['message_id'] ?>">
        <button type="submit" class="btn btn-danger">Delete Message</button>
    </form>
</div>
