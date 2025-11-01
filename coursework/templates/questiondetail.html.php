
<h2>Question Detail</h2>
<blockquote class="question-detail">
    <strong><em><?=htmlspecialchars($question['module_name'], ENT_QUOTES, 'UTF-8')?><br></em></strong>
    <span class="title"><?=htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8')?></span><br>
    <span class="content"><?=nl2br(htmlspecialchars($question['content'], ENT_QUOTES, 'UTF-8'))?></span><br>
    <?php if (!empty($question['image'])): ?>
        <img height="150" src="images/<?=htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8')?>" alt="Question image">
    <?php endif; ?>
    <br>
    (by <a href="mailto:<?=htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8')?>">
        <?=htmlspecialchars($question['username'], ENT_QUOTES, 'UTF-8')?></a>)<br>
    <span class="time">Posted: <?=htmlspecialchars($question['created_at'], ENT_QUOTES, 'UTF-8')?></span>
</blockquote>

<a href="questions.php">&larr; Back to Questions</a>
<hr>

<h3>Answers</h3>
<?php if (!empty($answers)): ?>
    <?php foreach ($answers as $answer): ?>
        <blockquote class="answer">
            <span class="content"><?=nl2br(htmlspecialchars($answer['content'], ENT_QUOTES, 'UTF-8'))?></span><br>
            <?php if (!empty($answer['image'])): ?>
                <img height="100" src="images/<?=htmlspecialchars($answer['image'], ENT_QUOTES, 'UTF-8')?>" alt="Answer image">
            <?php endif; ?>
            <br>
            (by <a href="mailto:<?=htmlspecialchars($answer['email'], ENT_QUOTES, 'UTF-8')?>">
                <?=htmlspecialchars($answer['username'], ENT_QUOTES, 'UTF-8')?></a>)<br>
            <span class="time">Answered: <?=htmlspecialchars($answer['created_at'], ENT_QUOTES, 'UTF-8')?></span>
        </blockquote>
    <?php endforeach; ?>
<?php else: ?>
    <p>No answers yet.</p>
<?php endif; ?>
