<div class="question-header-row">
    <a href="questions.php">&larr; Back to Questions</a>
    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $question['user_id']): ?>
        <a href="editquestion.php?id=<?=$question['question_id']?>" class="btn btn-edit">Edit Your Question</a>
    <?php endif; ?>
</div>

<blockquote class="question-detail">
    <div class="question-detail-meta">
        <span class="module-tag"><?=htmlspecialchars($question['module_name'], ENT_QUOTES, 'UTF-8')?><?php if (strpos($question['module_name'], '[Archived]') !== false): ?><?php endif; ?></span>
        <span class="separator">-</span>
        <span class="question-date"><?=htmlspecialchars(date('d/m/Y H:i', strtotime($question['created_at'])), ENT_QUOTES, 'UTF-8')?></span>
        <span class="separator">-</span>
        <span class="view-count"><?= (int)$question['view_count'] ?> views</span>
    </div>
    <p class="question-author"><a href="mailto:<?=htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8')?>">
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

    <?php if (isset($_SESSION['user_id'])): ?>
    <form action="addanswer.php" method="post" enctype="multipart/form-data">
        <?= csrfField() ?>
        <input type="hidden" name="question_id" value="<?=$question['question_id']?>">
        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
        <p class="form-note">Answering as: <strong><?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></strong></p>
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
    <?php else: ?>
    <p class="login-prompt">Please <a href="<?= BASE_URL ?>/auth/login.php">login</a> to submit an answer.</p>
    <?php endif; ?>
</div>

<hr>

<h3><?=getTotalAnswersForQuestion($pdo, $question['question_id'])?> Answers</h3>
<?php if (!empty($answers)): ?>
    <?php foreach ($answers as $answer): ?>
        <div class="answer <?= $answer['is_accepted'] ? 'answer-accepted' : '' ?>">
            <?php if ($answer['is_accepted']): ?>
                <span class="accepted-badge">✓ Accepted Answer</span>
            <?php endif; ?>
            <p><strong><?=htmlspecialchars($answer['username'], ENT_QUOTES, 'UTF-8')?></strong> - <?=htmlspecialchars(date('d/m/Y H:i', strtotime($answer['created_at'])), ENT_QUOTES, 'UTF-8')?></p>
            <p><?=htmlspecialchars($answer['content'], ENT_QUOTES, 'UTF-8')?></p>
            <?php if (!empty($answer['image'])): ?>
                <img src="images/<?=htmlspecialchars($answer['image'], ENT_QUOTES, 'UTF-8')?>" alt="Answer image">
            <?php endif; ?>
            
            <div class="answer-actions">
                <?php // Question owner can accept/unaccept answers ?>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $question['user_id'] && $answer['user_id'] != $question['user_id']): ?>
                    <form action="acceptanswer.php" method="post" style="display: inline;">
                        <?= csrfField() ?>
                        <input type="hidden" name="answer_id" value="<?=$answer['answer_id']?>">
                        <input type="hidden" name="question_id" value="<?=$question['question_id']?>">
                        <?php if ($answer['is_accepted']): ?>
                            <input type="hidden" name="action" value="unaccept">
                            <button type="submit" class="btn btn-unaccept btn-sm">Unaccept</button>
                        <?php else: ?>
                            <input type="hidden" name="action" value="accept">
                            <button type="submit" class="btn btn-accept btn-sm">Accept Answer</button>
                        <?php endif; ?>
                    </form>
                <?php endif; ?>
                
                <?php // Answer owner can edit/delete ?>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $answer['user_id']): ?>
                    <a href="editanswer.php?id=<?=$answer['answer_id']?>" class="btn btn-edit btn-sm">Edit</a>
                    <form action="deleteanswer.php" method="post" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this answer?');">
                        <?= csrfField() ?>
                        <input type="hidden" name="answer_id" value="<?=$answer['answer_id']?>">
                        <input type="hidden" name="question_id" value="<?=$question['question_id']?>">
                        <button type="submit" class="btn btn-delete btn-sm">Delete</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="empty-state-box empty-state-small">
        <p class="empty-state-icon">💬</p>
        <p>No answers yet. Be the first to help!</p>
    </div>
<?php endif; ?>
