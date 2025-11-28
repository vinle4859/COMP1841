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

<!-- Answer Form - right under question for better UX -->
<div class="quick-answer-form">
    <h3>Add Your Answer</h3>
    <?php if (!empty($answerError)): ?>
        <div class="errors"><?=htmlspecialchars($answerError, ENT_QUOTES, 'UTF-8')?></div>
    <?php endif; ?>
    <?php if (!empty($answerSuccess)): ?>
        <div class="success"><?=htmlspecialchars($answerSuccess, ENT_QUOTES, 'UTF-8')?></div>
    <?php endif; ?>

    <form action="addanswer.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="question_id" value="<?=$question['question_id']?>">
        <p>
            <label for="user_id">Your Name:</label>
            <select name="user_id" id="user_id" required>
                <option value="">-- Select your name --</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?=$user['user_id']?>"><?=htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8')?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="answer_content">Your Answer:</label>
            <textarea name="answer_content" id="answer_content" rows="4" required placeholder="Write your answer here..."><?=htmlspecialchars($answerContent ?? '', ENT_QUOTES, 'UTF-8')?></textarea>
        </p>
        <p>
            <label for="image">Attach Image (optional):</label>
            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif">
            <small>Max 2MB. Allowed: JPG, PNG, GIF</small>
        </p>
        <p>
            <input type="submit" value="Submit Answer">
        </p>
    </form>
</div>

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
    <p>No answers yet. Be the first to answer!</p>
<?php endif; ?>
