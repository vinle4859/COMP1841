<div class="message-detail-header">
    <div>
        <p><a href="messages.php">&larr; Back to Messages</a></p>
        <h2>Message #<?= (int)$message['message_id'] ?></h2>
    </div>
    <div class="message-status-control">
        <form action="messagedetail.php?id=<?= (int)$message['message_id'] ?>" method="post" class="inline-status-form">
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="new" <?= ($message['status'] === 'new' ? 'selected' : '') ?>>New</option>
                <option value="read" <?= ($message['status'] === 'read' ? 'selected' : '') ?>>Read</option>
                <option value="resolved" <?= ($message['status'] === 'resolved' ? 'selected' : '') ?>>Resolved</option>
            </select>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <form action="deletemessage.php" method="post" class="confirm-delete inline-form">
            <input type="hidden" name="message_id" value="<?= (int)$message['message_id'] ?>">
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>

<div class="message-detail-body">
    <p><strong>From:</strong> <?= htmlspecialchars($message['sender_name'] ?? 'Anonymous', ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($message['sender_email'] ?? 'Not provided', ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Received:</strong> <?= htmlspecialchars(date('M j, Y \a\t g:i A', strtotime($message['created_at'])), ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Subject:</strong> <?= htmlspecialchars($message['subject'], ENT_QUOTES, 'UTF-8') ?></p>
    <hr>
    <div class="message-content-text"><?= nl2br(htmlspecialchars($message['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?></div>
</div>
