<h2>Message #<?= (int)$message['message_id'] ?></h2>
<p><strong>From:</strong> <?=htmlspecialchars($message['username'] ?? '', ENT_QUOTES, 'UTF-8')?><?php if (!empty($message['email'])): ?> (<?=htmlspecialchars($message['email'], ENT_QUOTES, 'UTF-8')?>)<?php endif; ?></p>
<p><strong>Email:</strong> <?=htmlspecialchars($message['email'] ?? '', ENT_QUOTES, 'UTF-8')?></p>
<p><strong>When:</strong> <?=htmlspecialchars($message['created_at'], ENT_QUOTES, 'UTF-8')?></p>
<p><strong>Subject:</strong> <?=htmlspecialchars($message['subject'], ENT_QUOTES, 'UTF-8')?></p>
<hr>
<div style="white-space:pre-wrap;"><?=htmlspecialchars($message['content'] ?? '', ENT_QUOTES, 'UTF-8')?></div>
<hr>
<form action="messagedetail.php?id=<?= (int)$message['message_id'] ?>" method="post">
    <label for="status">Status</label>
    <select id="status" name="status">
        <option value="new" <?=($message['status']==='new' ? 'selected' : '')?>>new</option>
        <option value="resolved" <?=($message['status']==='resolved' ? 'selected' : '')?>>resolved</option>
    </select>
    <input type="submit" value="Update">
</form>
