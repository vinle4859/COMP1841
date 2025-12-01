<div class="questionlist">
    <div class="questions">
        <div class="questions-header">
            <h2>Questions</h2>
            <p class="questions-count"><?=htmlspecialchars($totalQuestions, ENT_QUOTES, 'UTF-8')?> questions in the forum</p>
        </div>
        
        <!-- Search and Filter -->
        <form method="get" class="filter-form">
            <div class="filter-row">
                <div class="search-box">
                    <input type="text" name="search" placeholder="Search by title, content, or @author" 
                           value="<?= htmlspecialchars($rawSearch ?? '', ENT_QUOTES, 'UTF-8') ?>" style="min-width: 280px;">
                </div>
                <div class="filter-group">
                    <label for="module">Module:</label>
                    <select name="module" id="module">
                        <option value="">All Modules</option>
                        <?php foreach ($modules as $module): ?>
                            <option value="<?=$module['module_id']?>" <?= (isset($moduleFilter) && $moduleFilter == $module['module_id']) ? 'selected' : '' ?>>
                                <?=htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8')?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="filter-actions">
                <button type="submit">Search</button>
                <?php if (isLoggedIn()): ?>
                    <a href="questions.php?search=@mine" class="btn-mine <?= (isset($userFilter) && $userFilter == $_SESSION['user_id']) ? 'active' : '' ?>">My Questions</a>
                <?php endif; ?>
                <?php if ($rawSearch || $moduleFilter): ?>
                    <a href="questions.php" class="btn-clear">Clear All</a>
                <?php endif; ?>
            </div>
        </form>
        
        <div class="question-list-items">
        <?php foreach($questions as $question): ?>
            <article class="question-card <?= (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $question['user_id']) ? 'own-question' : '' ?>">
                <div class="question-main">
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $question['user_id']): ?>
                        <span class="your-post-badge">Your Question</span>
                    <?php endif; ?>
                    <span class="module-tag"><?=htmlspecialchars($question['module_name'], ENT_QUOTES, 'UTF-8')?></span>
                    <h3 class="question-title">
                        <a href="questiondetail.php?id=<?=$question['question_id']?>">
                            <?=htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8')?>
                        </a>
                    </h3>
                </div>
                <div class="question-meta">
                    <span class="author">by <a href="?author=<?=urlencode($question['username'])?>"><?=htmlspecialchars($question['username'], ENT_QUOTES, 'UTF-8');?></a></span>
                    <span class="date"><?=htmlspecialchars(date('M j, Y', strtotime($question['created_at'])), ENT_QUOTES, 'UTF-8')?></span>
                    <span class="view-count">👁 <?= (int)$question['view_count'] ?></span>
                </div>
                <?php if (!empty($question['image'])): ?>
                    <div class="question-image">
                        <img src="images/<?=htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Question image">
                    </div>
                <?php endif; ?>
                <div class="question-actions">
                    <a href="questiondetail.php?id=<?=$question['question_id']?>" class="btn-view">View Details</a>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $question['user_id']): ?>
                        <a href="editquestion.php?id=<?=$question['question_id']?>" class="btn-edit">Edit</a>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach;?>
        </div>
    </div>
</div>
    
