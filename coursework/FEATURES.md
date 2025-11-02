FEATURES
========

Purpose
-------
This document lists the application's functional features (broken down by user role), the current expected implementation state (as a checklist), where to look in the codebase for the relevant implementation, simple acceptance checks, and suggested next steps.

How to use this file
--------------------
- Use the "Status" checkboxes to record what is implemented in the current codebase. Update after verifying behavior in the running app.
- Each feature has "Files / Notes" with file paths or SQL table hints to help you verify or implement the feature.
- The "Next steps" items show practical follow-ups or tests to finish/strengthen each feature.

1. Guest (Unauthenticated user)
-------------------------------
- [ ] View Content: Guests can browse and read all questions and answers that have an `active` status.
  - Files / Notes:
    - `questions.php`, `templates/questions.html.php`, `templates/questiondetail.html.php`
    - DB: `question.status = 'active'` and `answer.status = 'active'` expected filter
  - Acceptance check:
    - Visit `questions.php` and `questiondetail.php?id=<id>` as a non-logged-in user and verify only active items are shown.
  - Next steps: Ensure queries filter by status; add unit/integration test to confirm.

- [ ] Search/Filter: Guests can view questions filtered by module or tag.
  - Files / Notes:
    - `questions.php` may accept GET params (e.g., `?module=...`)
    - UI: `templates/questions.html.php` shows categories; confirm server-side filtering in `questions.php` or `DatabaseFunctions.php`.
  - Acceptance check: Use `?module=<module_id>` and verify results.
  - Next steps: Add UI for tags (if missing) and server-side sanitised filtering.

- [ ] User Registration (signup)
  - Files / Notes:
    - `adduser` or `register` pages (not present in the current templates list). Check `includes/DatabaseFunctions.php` for `createUser`.
  - Acceptance check: Submit registration form and confirm `user_account` row created.
  - Next steps: Implement registration form and server-side validation if missing.

- [ ] User Login
  - Files / Notes:
    - Likely `login.php`, session handling in `includes/DatabaseFunctions.php`.
  - Acceptance check: Log in using stored credentials; confirm session and access to authenticated pages.
  - Next steps: Add secure password storage (password_hash), session regeneration.

- [ ] Password Recovery (Forgot Password)
  - Files / Notes:
    - Not present in templates; DB must have `password_reset` table or `user_account.password_reset_token`.
  - Acceptance check: Trigger forgot-password flow; verify a token is generated and displayed (prototype) and can be used to set a new password.
  - Next steps: Implement token creation, expiry checks, and reset form.

- [ ] Contact Form
  - Files / Notes:
    - Look for `contact.php` or message handling in `includes/DatabaseFunctions.php` and `message` DB table.
  - Acceptance check: Submit message as guest; confirm `message` table record with NULL user_id.
  - Next steps: Add form and simple spam prevention (honeypot or rate limit).

2. Student (Authenticated user_account)
--------------------------------------
- [ ] Profile Management (view/edit profile)
  - Files / Notes:
    - `profile.php`, `editprofile.php` or user functions in `includes/DatabaseFunctions.php`.
  - Acceptance check: Logged-in user visits profile, changes username/email and sees DB update.
  FEATURES
  ========

  Purpose
  -------
  This document now prioritises the core functional features the coursework must demonstrate. The primary goal is to implement and showcase the base application behaviour first (viewing and managing posts, managing users and modules, image attachments and a contact form). Security and hardening remain important and are recorded, but they are secondary to implementing the core demonstration features.

  How to use this file
  --------------------
  - Use the checklist to track features as they are implemented for the coursework demonstration.
  - Each feature has acceptance checks and files to look at so you can quickly verify the work locally.

  Priority functional requirements (core demonstration features)
  ------------------------------------------------------------
  These are ordered by importance for a coursework submission and demonstration.

  1) Public-facing question list (read-only front end)
  - Description: Display a list of questions/posts for students to browse.
  - Files / Notes: `questions.php`, `templates/questions.html.php`, `includes/DatabaseFunctions.php`
  - Acceptance: `questions.php` lists questions with title, excerpt, module and author; pagination or date sorting available.

  2) Post CRUD (add, edit, delete a question)
  - Description: Allow a student to add, edit and soft-delete their own posts.
  - Files / Notes: `addquestion.php`, `editquestion.php`, `deletequestion.php`, `templates/addquestion.html.php`, `templates/editquestion.html.php`, `includes/DatabaseFunctions.php`
  - Acceptance: A user can create a post (title, content, optional image, select module), can edit it, and can soft-delete it (status change) so it disappears from public lists.

  3) Author and module management
  - Description: Manage lists of authors (users) and module names; modules are selectable when creating/editing posts.
  - Files / Notes: `modules.php`, `editmodule.php`, `users.php` (or existing user-management pages), `includes/DatabaseFunctions.php`
  - Acceptance: Admin or demonstration user can add/edit modules and they appear in the post creation/edit forms as dropdown options.

  4) Contact form to send messages to admin
  - Description: Provide a contact form so students can send messages to the system administrator (demo may log the message instead of sending mail).
  - Files / Notes: `contact.php`, `templates/contact.html.php`, optionally `includes/DatabaseFunctions.php` for message storage.
  - Acceptance: Submitting the form shows success feedback and logs or (in demo mode) emails the message to the configured admin address.

  5) Image upload and display for posts
  - Description: Allow attaching an image/screenshot to a post and display it on the question detail page.
  - Files / Notes: `addquestion.php`, `editquestion.php`, `templates/*`, `images/`, `includes/DatabaseFunctions.php`
  - Acceptance: Uploaded image displays with the post; upload validation restricts file types and size.

  Secondary (important) items
  --------------------------
  - Input validation and prepared statements (server-side validation and PDO prepared statements should be used anywhere user input is stored). See `includes/DatabaseFunctions.php`.
  - Security hardening (password hashing, session handling, CSRF tokens): important but implemented after the core features are demonstrable for coursework. See suggested roadmap below.

  Suggested immediate roadmap for the coursework
  -------------------------------------------
  1. Implement the five core features above in the order listed. Each feature should have a minimal, working flow for the demo.
  2. Add basic input validation, and use prepared statements for DB queries when accepting user input.
  3. Implement simple image upload restrictions and store images under `images/` with safe filenames.
  4. Add authentication (simple registration/login) so the post CRUD flows can be demonstrated with ownership enforced.
  5. Add lightweight admin screens for managing modules and users.

  Verification
  ------------
  - Run the app locally (XAMPP) and exercise the core flows: view list, add/edit/delete a question, upload an image, manage modules, use the contact form.
  - For each item above, mark the checklist once the behaviour is visible in the running app.

  Where to document and enforce
  ----------------------------
  - Update this `FEATURES.md` as features are implemented.
  - Add a `SECURITY.md` later for deployment-focused hardening once the demo features are complete.

  Change log
  ----------
  - 2025-11-02: Reordered and updated FEATURES.md to prioritise core demonstration features per user instruction.
  - Acceptance check: Admin marks message resolved; status updates in DB.



Cross-cutting & Misc

