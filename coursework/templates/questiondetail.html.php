<a href="questions.php">&larr; Back to Questions</a>

<blockquote class="question-detail">
    <h3><?=htmlspecialchars($question['module_name'], ENT_QUOTES, 'UTF-8')?> - <?=htmlspecialchars(date('d/m/Y H:i', strtotime($question['created_at'])), ENT_QUOTES, 'UTF-8')?></h3>
    <p><a href="mailto:<?=htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8')?>">
        <?=htmlspecialchars($question['username'], ENT_QUOTES, 'UTF-8')?></a></p>
    
    <h2><?=htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8')?></h2>
    <p><?=htmlspecialchars($question['content'], ENT_QUOTES, 'UTF-8')?></p>
    
    <?php if (!empty($question['image'])): ?>
        <img height="150" src="images/<?=htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8')?>" alt="Question image">
    <?php endif; ?>
</blockquote>

<hr>

<h3><?=getTotalAnswers($pdo, $question['question_id'])?> Answers</h3>
<?php if (!empty($answers)): ?>
    <?php foreach ($answers as $answer): ?>
        <div class="answer">
            <p><strong><?=htmlspecialchars($answer['username'], ENT_QUOTES, 'UTF-8')?></strong> - <?=htmlspecialchars(date('d/m/Y H:i', strtotime($answer['created_at'])), ENT_QUOTES, 'UTF-8')?></p>
            <p><?=htmlspecialchars($answer['content'], ENT_QUOTES, 'UTF-8')?></p>
            <?php if (!empty($answer['image'])): ?>
                <img src="images/<?=htmlspecialchars($answer['image'], ENT_QUOTES, 'UTF-8')?>" alt="Answer image">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No answers yet.</p>
<?php endif; ?>
