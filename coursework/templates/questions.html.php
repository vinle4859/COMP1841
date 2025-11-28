<div class="questionlist">
    <div class="questions">
        <h2><?=htmlspecialchars($totalQuestions, ENT_QUOTES, 'UTF-8')?> questions have been submitted to the Student Forum since 2024</h2>
        
        <!-- Module Filter -->
        <form method="get" class="filter-form">
            <label for="module">Filter by Module:</label>
            <select name="module" id="module" onchange="this.form.submit()">
                <option value="">All Modules</option>
                <?php foreach ($modules as $module): ?>
                    <option value="<?=$module['module_id']?>" <?= (isset($moduleFilter) && $moduleFilter == $module['module_id']) ? 'selected' : '' ?>>
                        <?=htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8')?>
                    </option>
                <?php endforeach; ?>
            </select>
            <noscript><input type="submit" value="Filter"></noscript>
        </form>
        
        <br>
        <?php foreach($questions as $question): ?>
            <blockquote>
                <p class="question-header">
                    <strong><em><?=htmlspecialchars($question['module_name'], ENT_QUOTES, 'UTF-8')?></em></strong>
                    <a href="questiondetail.php?id=<?=$question['question_id']?>">
                        <?=htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8')?>
                    </a>
                </p>
                <p>(by <a href="mailto:<?=htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8');?>">
                    <?=htmlspecialchars($question['username'], ENT_QUOTES, 'UTF-8');?>
                </a>) - Posted: <?=htmlspecialchars(date('d/m/y H:i', strtotime($question['created_at'])), ENT_QUOTES, 'UTF-8')?></p>
                
                <?php if (!empty($question['image'])): ?>
                    <div style="margin: 0.75rem 0;">
                        <img height='100px' src="images/<?=htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Question image" style="display: block;">
                    </div>
                <?php endif; ?>
            </blockquote>
        <?php endforeach;?>
    </div>
</div>
    
