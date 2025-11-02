<form action="" method="post" class="needs-validation" novalidate>
    <input type="hidden" name="question_id" value="<?=htmlspecialchars($question['question_id'], ENT_QUOTES, 'UTF-8')?>">
    <!-- Edit Title -->
    <label for="title">Edit your question title here:</label>
    <input type="text" id="title" name="title" value="<?=htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8')?>" required maxlength="255">

    <!-- Edit Content -->
    <label for="content">Edit your question here:</label>
    <textarea id="content" name="content" rows="5" cols="80" required><?=htmlspecialchars($question['content'], ENT_QUOTES, 'UTF-8')?></textarea>
    <input type="submit" name="submit" value="Save">
</form>
    </textarea>

