<div class="questionlist">
    <div class="questions">
        <div class="questions-header">
            <h2>Questions</h2>
            <p class="questions-count"><?=htmlspecialchars($totalQuestions, ENT_QUOTES, 'UTF-8')?> questions in the forum</p>
        </div>
        
        <!-- Search and Filter -->
        <form method="get" class="filter-form">
            <div class="search-box">
                <input type="text" name="search" placeholder="Search questions..." 
                       value="<?= htmlspecialchars($searchTerm ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <label for="module">Module:</label>
            <select name="module" id="module">
                <option value="">All Modules</option>
                <?php foreach ($modules as $module): ?>
                    <option value="<?=$module['module_id']?>" <?= (isset($moduleFilter) && $moduleFilter == $module['module_id']) ? 'selected' : '' ?>>
                        <?=htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8')?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Search</button>
            <?php if ($searchTerm || $moduleFilter): ?>
                <a href="questions.php" class="btn-clear">Clear</a>
            <?php endif; ?>
        </form>
        
        <div class="question-list-items">
        <?php foreach($questions as $question): ?>
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
                    <span class="author">by <a href="mailto:<?=htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8');?>"><?=htmlspecialchars($question['username'], ENT_QUOTES, 'UTF-8');?></a></span>
                    <span class="date"><?=htmlspecialchars(date('M j, Y \a\t g:i A', strtotime($question['created_at'])), ENT_QUOTES, 'UTF-8')?></span>
                </div>
                <?php if (!empty($question['image'])): ?>
                    <div class="question-image">
                        <img src="images/<?=htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Question image">
                    </div>
                <?php endif; ?>
                <div class="question-actions">
                    <a href="questiondetail.php?id=<?=$question['question_id']?>" class="btn-view">View Details</a>
                </div>
            </article>
        <?php endforeach;?>
        </div>
    </div>
</div>
    
