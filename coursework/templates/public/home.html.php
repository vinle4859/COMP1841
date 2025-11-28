<div class="home-hero">
    <h2>Welcome to the Student Forum</h2>
    <p class="tagline">Your place to ask questions, share knowledge, and connect with fellow students</p>
    <div class="home-actions">
        <a href="questions.php" class="btn-primary">Browse Questions</a>
        <a href="addquestion.php" class="btn-secondary">Ask a Question</a>
    </div>
</div>

<div class="home-stats">
    <div class="stat-item">
        <span class="stat-number"><?= htmlspecialchars($totalQuestions) ?></span>
        <span class="stat-label">Questions</span>
    </div>
    <div class="stat-item">
        <span class="stat-number"><?= htmlspecialchars($totalAnswers) ?></span>
        <span class="stat-label">Answers</span>
    </div>
</div>

<div class="home-features">
    <div class="feature-card">
        <h3>📚 Module-Based</h3>
        <p>Questions organized by modules for easy navigation and filtering</p>
    </div>
    <div class="feature-card">
        <h3>💬 Get Answers</h3>
        <p>Post your questions and receive help from the community</p>
    </div>
    <div class="feature-card">
        <h3>🔍 Easy Search</h3>
        <p>Filter questions by module to find exactly what you need</p>
    </div>
</div>

<?php if (!empty($recentQuestions)): ?>
<div class="recent-questions">
    <h3>Recent Questions</h3>
    <div class="question-list-items">
        <?php foreach($recentQuestions as $question): ?>
            <article class="question-card">
                <div class="question-main">
                    <h3 class="question-title">
                        <a href="questiondetail.php?id=<?=$question['question_id']?>">
                            <?=htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8')?>
                        </a>
                    </h3>
                    <span class="module-tag"><?=htmlspecialchars($question['module_name'], ENT_QUOTES, 'UTF-8')?></span>
                </div>
                <div class="question-meta">
                    <span class="author">by <?=htmlspecialchars($question['username'], ENT_QUOTES, 'UTF-8');?></span>
                    <span class="date"><?=htmlspecialchars(date('M j, Y', strtotime($question['created_at'])), ENT_QUOTES, 'UTF-8')?></span>
                </div>
            </article>
        <?php endforeach;?>
    </div>
    <p style="margin-top: 1.5rem; text-align: center;">
        <a href="questions.php" class="btn-secondary">View All Questions →</a>
    </p>
</div>
<?php endif; ?>
