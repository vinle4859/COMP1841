<div class="questionlist">
    <div class="questions">
        <div class="admin-list-header">
            <div class="questions-summary">
                <h2>Questions</h2>
                <p class="summary-text"><?=htmlspecialchars($totalQuestions, ENT_QUOTES, 'UTF-8')?> questions submitted since 2024</p>
            </div>
            <div>
                <a href="addquestion.php" class="admin-action">+ Add question</a>
            </div>
        </div>
        
        <!-- Search Filters -->
        <form method="get" class="filter-form admin-filters">
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
            <div class="filter-group">
                <label for="user">User:</label>
                <select name="user" id="user">
                    <option value="">All Users</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?=$user['user_id']?>" <?= (isset($userFilter) && $userFilter == $user['user_id']) ? 'selected' : '' ?>>
                            <?=htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8')?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group filter-actions">
                <input type="submit" value="Filter" class="admin-action">
                <?php if ($moduleFilter || $userFilter): ?>
                    <a href="questions.php" class="btn-link">Clear</a>
                <?php endif; ?>
            </div>
        </form>
        
        <?php foreach($questions as $question): ?>
            <blockquote>
                <p class="question-header">
                    <strong><em><?=htmlspecialchars($question['module_name'], ENT_QUOTES, 'UTF-8')?></em></strong>
                    <a href="questiondetail.php?id=<?=$question['question_id']?>"><?=htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8')?></a>
                </p>
                <p>(by <a href="mailto:<?=htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8');?>">
                    <?=htmlspecialchars($question['username'], ENT_QUOTES, 'UTF-8');?>
                </a>) - Posted: <?=htmlspecialchars(date('d/m/y H:i', strtotime($question['created_at'])), ENT_QUOTES, 'UTF-8')?></p>
                
                <?php if (!empty($question['image'])): ?>
                    <div style="margin: 0.75rem 0;">
                        <img height='100px' src="../images/<?=htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Question image" style="display: block;">
                    </div>
                <?php endif; ?>
                
                <div class="actions" style="margin-top: 0.75rem;">
                    <a href="editquestion.php?id=<?=$question['question_id']?>" class="btn-link">Edit</a>
                    <form action="deletequestion.php" method="post" class="confirm-delete">
                        <input type="hidden" name="question_id" value="<?=$question['question_id']?>">
                        <input type="submit" value="Delete">
                    </form>
                </div>
            </blockquote>
        <?php endforeach;?>
        
    </div>
</div>
    
