<div class="profile-page">
    <h2>My Profile</h2>
    
    <?php if (!empty($error)): ?>
        <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    
    <div class="profile-layout">
        <!-- Profile Info Section -->
        <div class="profile-section">
            <h3>Account Information</h3>
            <div class="profile-stats">
                <div class="stat-badge">
                    <span class="stat-number"><?= htmlspecialchars($profile['question_count']) ?></span>
                    <span class="stat-label">Questions</span>
                </div>
                <div class="stat-badge">
                    <span class="stat-number"><?= htmlspecialchars($profile['answer_count']) ?></span>
                    <span class="stat-label">Answers</span>
                </div>
                <div class="stat-badge stat-date">
                    <span class="stat-label">Member since</span>
                    <span class="stat-value"><?= htmlspecialchars(date('M j, Y', strtotime($profile['created_at']))) ?></span>
                </div>
            </div>
            
            <form action="profile.php" method="post" class="profile-form">
                <?= csrfField() ?>
                <input type="hidden" name="action" value="update_profile">
                
                <div class="form-group">
                    <label for="username">Username<span class="required">*</span></label>
                    <input type="text" id="username" name="username" required minlength="3" maxlength="50"
                           value="<?= htmlspecialchars($profile['username'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address<span class="required">*</span></label>
                    <input type="email" id="email" name="email" required
                           value="<?= htmlspecialchars($profile['email'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
        
        <!-- Password Change Section -->
        <div class="profile-section">
            <h3>Change Password</h3>
            <form action="profile.php" method="post" class="profile-form">
                <?= csrfField() ?>
                <input type="hidden" name="action" value="change_password">
                
                <div class="form-group">
                    <label for="current_password">Current Password<span class="required">*</span></label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                
                <div class="form-group">
                    <label for="new_password">New Password<span class="required">*</span></label>
                    <input type="password" id="new_password" name="new_password" required minlength="6">
                    <small>Minimum 6 characters</small>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password<span class="required">*</span></label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="profile-activity">
        <div class="activity-column">
            <h3>Your Recent Questions</h3>
            <?php if (!empty($myQuestions)): ?>
                <ul class="activity-list">
                    <?php foreach($myQuestions as $q): ?>
                        <li>
                            <a href="questiondetail.php?id=<?= $q['question_id'] ?>"><?= htmlspecialchars($q['title'], ENT_QUOTES, 'UTF-8') ?></a>
                            <span class="activity-date"><?= htmlspecialchars(date('M j, Y', strtotime($q['created_at']))) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a href="questions.php?author=mine" class="view-all">View all questions →</a>
            <?php else: ?>
                <p class="empty-state">No questions yet. <a href="addquestion.php">Ask your first question!</a></p>
            <?php endif; ?>
        </div>
        
        <div class="activity-column">
            <h3>Your Recent Answers</h3>
            <?php if (!empty($myAnswers)): ?>
                <ul class="activity-list">
                    <?php foreach($myAnswers as $a): ?>
                        <li>
                            <a href="questiondetail.php?id=<?= $a['question_id'] ?>">Re: <?= htmlspecialchars($a['question_title'], ENT_QUOTES, 'UTF-8') ?></a>
                            <span class="activity-date"><?= htmlspecialchars(date('M j, Y', strtotime($a['created_at']))) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="empty-state">No answers yet. <a href="questions.php">Help others by answering!</a></p>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if (!isAdmin()): ?>
    <!-- Account Deletion (not available for admins) -->
    <div class="profile-section danger-zone">
        <h3>Delete Account</h3>
        <p>Account deletion has a 30-day grace period. During this time, you can contact us to restore your account. After the grace period or at your request, your personal data will be permanently removed.</p>
        
        <details class="delete-account-details">
            <summary>Delete my account</summary>
            <form action="profile.php" method="post" class="delete-form" onsubmit="return confirm('Are you absolutely sure? This cannot be undone.');">
                <?= csrfField() ?>
                <input type="hidden" name="action" value="delete_account">
                
                <div class="form-group">
                    <label for="delete_password">Enter your password</label>
                    <input type="password" id="delete_password" name="delete_password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_delete">Type DELETE to confirm</label>
                    <input type="text" id="confirm_delete" name="confirm_delete" required pattern="DELETE" placeholder="DELETE">
                </div>
                
                <button type="submit" class="btn-danger">Permanently Delete Account</button>
            </form>
        </details>
    </div>
    <?php endif; ?>
</div>
