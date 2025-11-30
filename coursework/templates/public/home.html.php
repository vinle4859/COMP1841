<?php if (isLoggedIn()): ?>
<!-- Logged-in user view -->
<div class="home-hero">
    <h2>Welcome back, <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?>!</h2>
    <p class="tagline">Ready to learn and share knowledge?</p>
    <div class="home-actions">
        <a href="questions.php" class="btn-primary">Browse Questions</a>
        <a href="addquestion.php" class="btn-secondary">Ask a Question</a>
        <a href="profile.php" class="btn-tertiary">My Profile</a>
    </div>
</div>

<?php if (!empty($recentQuestions)): ?>
<div class="recent-questions">
    <h3>Recent Questions</h3>
    <div class="question-preview-list">
        <?php foreach($recentQuestions as $question): ?>
            <div class="question-preview">
                <a href="questiondetail.php?id=<?=$question['question_id']?>">
                    <?=htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8')?>
                </a>
                <span class="preview-meta"><?=htmlspecialchars($question['module_name'], ENT_QUOTES, 'UTF-8')?> · <?=htmlspecialchars(date('M j', strtotime($question['created_at'])), ENT_QUOTES, 'UTF-8')?></span>
            </div>
        <?php endforeach;?>
    </div>
    <p class="view-all-link">
        <a href="questions.php">View All Questions →</a>
    </p>
</div>
<?php endif; ?>

<?php else: ?>
<!-- Guest view -->
<div class="home-hero">
    <h2>Welcome to the Student Forum</h2>
    <p class="tagline">Your place to ask questions, share knowledge, and connect with fellow students</p>
    <div class="home-actions">
        <a href="questions.php" class="btn-primary">Browse Questions</a>
        <a href="auth/signup.php" class="btn-secondary">Sign Up to Ask</a>
    </div>
</div>

<?php if (!empty($recentQuestions)): ?>
<div class="recent-questions">
    <h3>Recent Questions</h3>
    <div class="question-preview-list">
        <?php foreach($recentQuestions as $question): ?>
            <div class="question-preview">
                <a href="questiondetail.php?id=<?=$question['question_id']?>">
                    <?=htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8')?>
                </a>
                <span class="preview-meta"><?=htmlspecialchars($question['module_name'], ENT_QUOTES, 'UTF-8')?> · <?=htmlspecialchars(date('M j', strtotime($question['created_at'])), ENT_QUOTES, 'UTF-8')?></span>
            </div>
        <?php endforeach;?>
    </div>
    <p class="view-all-link">
        <a href="questions.php">View All Questions →</a>
    </p>
</div>
<?php endif; ?>
<?php endif; ?>
