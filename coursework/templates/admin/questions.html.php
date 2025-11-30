<div class="questionlist">
    <div class="questions">
        <div class="admin-list-header">
            <div class="questions-summary">
                <h2>Questions</h2>
                <p class="summary-text"><?=htmlspecialchars($totalQuestions, ENT_QUOTES, 'UTF-8')?> questions in the forum</p>
            </div>
            <div>
                <a href="addquestion.php" class="admin-action">+ Add question</a>
            </div>
        </div>
        
        <!-- Search and Filters -->
        <form method="get" class="filter-form admin-filters-horizontal">
            <div class="filter-row">
                <input type="text" name="search" id="search" placeholder="Search questions..." 
                       value="<?= htmlspecialchars($searchTerm ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <select name="module" id="module">
                    <option value="">All Modules</option>
                    <?php foreach ($modules as $module): ?>
                        <option value="<?=$module['module_id']?>" <?= (isset($moduleFilter) && $moduleFilter == $module['module_id']) ? 'selected' : '' ?>>
                            <?=htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8')?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="author" id="author" placeholder="Search by username..." 
                       value="<?= htmlspecialchars($authorSearch ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <button type="submit" class="admin-action">Search</button>
                <?php if ($moduleFilter || $authorSearch || $searchTerm): ?>
                    <a href="questions.php" class="btn-link">Clear</a>
                <?php endif; ?>
            </div>
        </form>
        
        <div class="question-list-items">
        <?php foreach($questions as $question): ?>
            <article class="question-card admin-card">
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
                    <span class="date"><?=htmlspecialchars(date('M j, Y \\a\\t g:i A', strtotime($question['created_at'])), ENT_QUOTES, 'UTF-8')?></span>
                </div>
                <?php if (!empty($question['image'])): ?>
                    <div class="question-image">
                        <img src="../images/<?=htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Question image">
                    </div>
                <?php endif; ?>
                <div class="question-actions">
                    <a href="questiondetail.php?id=<?=$question['question_id']?>" class="btn-view">View Details</a>
                    <a href="editquestion.php?id=<?=$question['question_id']?>" class="btn-edit">Edit</a>
                    <form action="deletequestion.php" method="post" class="confirm-delete inline-form">
                        <?= csrfField() ?>
                        <input type="hidden" name="question_id" value="<?=$question['question_id']?>">
                        <input type="submit" value="Delete" class="btn-delete">
                    </form>
                </div>
            </article>
        <?php endforeach;?>
        </div>
        
    </div>
</div>
    
