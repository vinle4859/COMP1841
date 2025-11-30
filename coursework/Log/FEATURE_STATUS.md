# COMP1841 Coursework - Feature Status & Improvement Plan

## Last Updated: December 2025

---

## Core Requirements (70 marks total)

### ✅ Display list of questions/posts (10 marks)
**Status: COMPLETE**
- Questions list with title, module, author, date
- Filter by module (dropdown)
- Search by question content/title
- Search by author username
- "My Questions" quick filter
- Pagination not implemented (could add for large datasets)

### ✅ Add, Edit, Delete posts (7 marks)
**Status: COMPLETE**
- Add question (logged-in users only)
- Edit own questions (title, content, image only - module locked)
- Delete: Removed for users (business decision - preserves answers)
- Admin can delete via admin panel

### ✅ Display image/screenshot for posts (3 marks)
**Status: COMPLETE**
- Image upload on question creation
- Image upload on question edit
- Image upload on answers
- Image validation (type, size)
- Images display in lists and detail views

### ✅ Contact form to admin (3 marks)
**Status: COMPLETE**
- Guest users: name + email fields
- Logged-in users: auto-linked to account
- Subject and message body
- Admin can view messages in admin panel

### ✅ Add, Edit, Delete users (7 marks)
**Status: COMPLETE**
- Admin: Full CRUD on users
- Admin: Soft delete (marks as deleted)
- Admin: Restore deleted users
- **NEW**: User self-service profile
  - Edit own username/email
  - Change password
  - Delete own account (soft delete)

### ✅ Assign post to module and user (3 marks)
**Status: COMPLETE**
- Module dropdown on question creation
- User auto-assigned from session
- Admin can reassign both

### ✅ Add, Edit, Delete modules (7 marks)
**Status: COMPLETE**
- Admin: Full CRUD on modules
- Soft delete (marks as archived)
- Restore deleted modules
- Questions show "[Archived]" for deleted modules

---

## Additional Features (30 marks - discretionary)

### ✅ Admin Area
**Status: COMPLETE**
- Separate admin layout
- Admin dashboard (questions, users, modules, messages)
- Protected routes (requireAdmin)

### ✅ Login System
**Status: COMPLETE**
- Login with username or email
- Session management
- Role-based access (user vs admin)

### ✅ Password Protection & Encryption
**Status: COMPLETE**
- bcrypt password hashing (PASSWORD_DEFAULT)
- Password verification on login
- Secure password change flow

### ✅ Forgotten Password Recovery
**Status: COMPLETE (Demo Mode)**
- Password reset token generation
- Token expiry (1 hour)
- Demo version displays reset link on screen
- In production, would send via email
- Reset password form with validation

### ✅ Sign Up System
**Status: COMPLETE**
- Registration with username, email, password
- Validation (unique username/email, password length)
- Auto-login after signup

### ✅ User Tracking (no dropdown)
**Status: COMPLETE**
- Session-based user tracking
- No user dropdown for question posting
- Automatic user assignment

### ✅ Front-end Design
**Status: GOOD**
- Responsive CSS layout
- Consistent styling across pages
- Clear navigation
- Visual feedback (success/error messages)

### ✅ Client-side Validation
**Status: COMPLETE**
- HTML5 required attributes
- Pattern validation
- Form confirmation dialogs

### ⚠️ Server-side Validation
**Status: PARTIAL**
- Most forms validated
- Could add more robust sanitization
- XSS protection via htmlspecialchars

### ✅ Rate Limiting
**Status: COMPLETE**
- Session-based rate limiting on login
- Max 5 failed attempts per 15 minutes
- Shows remaining attempts to user
- Auto-clears after lockout period

### ✅ Answer System (Not in specs - extra)
**Status: COMPLETE**
- Add answers to questions
- Edit own answers
- Delete own answers
- **NEW**: Accepted answer feature
  - Question owner can mark an answer as accepted
  - Only one accepted answer per question
  - Visual distinction (green styling)
  - Toggle to unaccept

---

## Recently Implemented Features

### ✅ CSRF Token Protection
**Status: COMPLETE**
- Centralized token generation in SessionFunctions.php
- Token validation on all POST forms
- initRequest() helper with csrf option
- Consistent protection across public and admin areas

### ✅ View Count Tracking
**Status: COMPLETE**
- Session-based tracking (one view per session per question)
- Prevents refresh spam
- Displayed on question detail page

### ✅ Message Read/Unread Status
**Status: COMPLETE**
- Auto-mark as read when admin views message
- Unread messages highlighted in inbox
- Unread count badge in admin navigation
- Status badges (new/read/resolved)

---

## Missing/Improvement Items for Next Development Round

### MEDIUM PRIORITY

1. **UI Polish**
   - [ ] Empty states for all lists
   - [ ] Loading indicators
   - [ ] Better mobile responsiveness

2. **Admin Enhancements**
   - [ ] Dashboard statistics cards
   - [ ] Bulk actions (delete multiple)
   - [ ] Activity logs

3. **Answer Voting**
   - [ ] Answer voting/likes
   - [ ] Sort answers by votes

### LOW PRIORITY (Nice to have)

4. **Search Improvements**
   - [ ] Full-text search
   - [ ] Search highlighting
   - [ ] Search suggestions

5. **Pagination**
   - [ ] Questions list pagination
   - [ ] Answers pagination

6. **User Features**
   - [ ] Avatar/profile picture
   - [ ] Public user profile page
   - [ ] User activity history

---

## Technical Debt

1. **Code Organization**
   - Some duplicate code in templates
   - Could use a Router class
   - Consider autoloading

2. **Security Hardening**
   - ✅ CSRF tokens - COMPLETE
   - HTTP-only cookies
   - Content Security Policy headers

3. **Performance**
   - Query optimization for large datasets
   - Caching for frequently accessed data

---

## Summary

| Category | Status | Estimated Marks |
|----------|--------|-----------------|
| Core Requirements (40 marks) | ✅ Complete | 38-40 |
| Additional Features (30 marks) | ✅ Complete | 28-30 |
| **Total System (70 marks)** | | **66-70** |

### Key Strengths:
- Full authentication system with rate limiting
- Password reset flow (demo mode)
- User self-management (profile, password, delete)
- Clean separation of public/admin areas
- Good UI/UX with dashboard for logged-in users
- Answer system with accepted answer feature
- CSRF protection on all forms
- View count tracking
- Message read/unread status with admin notifications
- Admin self-deletion prevention

### Key Gaps:
- Email sending not implemented (demo mode for password reset)
- No answer voting/likes system
