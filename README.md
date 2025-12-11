# COMP1841 - Student Forum Coursework

A full-featured Q&A forum system built with PHP and MySQL for the COMP1841 Web Programming course.

## 🔐 Admin Access

**Username:** `admin`  
**Password:** `admin123`

## ✨ Features

### Authentication & Security
- **User Registration** - Sign up with email verification
- **Login System** - Secure authentication with password hashing
- **Password Reset** - Email-based password recovery with tokens
- **CSRF Protection** - Token-based protection on all forms
- **Session Management** - Secure session handling and timeout
- **Rate Limiting** - Failed login attempt tracking
- **Role-Based Access** - Admin and regular user permissions

### Question & Answer System
- **Post Questions** - Create questions with titles and descriptions
- **Add/Edit/Delete Answers** - Respond to questions with detailed answers
- **Accept Answers** - Question owners can mark best answers
- **Edit/Delete** - Manage your own questions and answers
- **View Tracking** - Track question views with session-based counting
- **Module Assignment** - Organize questions by course modules

### Search & Filter
- **Search Questions** - Find questions by keyword in titles/content
- **Filter by Module** - Browse questions by specific modules
- **Filter by User** - View questions/answers by specific users

### User Management (Admin)
- **User CRUD** - Create, read, update, delete user accounts
- **Soft Delete/Restore** - Archive users without permanent deletion

### Module Management (Admin)
- **Module CRUD** - Manage course modules
- **Soft Delete/Restore** - Archive modules without data loss
- **Module Assignment** - Link questions to specific modules

### Contact System
- **Contact Form** - Guest and logged-in users can send messages
- **Message Management** - Admin can view and respond to messages
- **Status Tracking** - Mark messages as read/unread

### Profile & Settings
- **User Profiles** - View user information and statistics
- **Account Deletion** - Users can delete their own accounts
- **Activity History** - View your questions and answers

### UI & Validation
- **Client-Side Validation** - JavaScript validation for forms, images, and deletes
- **Server-Side Validation** - PHP validation for all inputs
- **Flash Messages** - Success/error notifications with session messages
- **Confirmation Dialogs** - JavaScript prompts for destructive actions

### Database
- **Prepared Statements** - SQL injection protection
- **Soft Deletes** - Status-based deletion for users and modules
- **Dynamic Queries** - Conditional WHERE clauses for filtering
- **Transaction Support** - Data integrity for complex operations

## 🚀 Setup

1. Import `coursework/comp1841_coursework.sql` into MySQL
2. Access via `http://localhost/COMP1841/coursework/`

## 📁 Project Structure

```
coursework/
├── index.php              # Homepage
├── questions.php          # Question listing
├── questiondetail.php     # Single question view
├── profile.php            # User profile
├── contact.php            # Contact form
├── auth/                  # Login, signup, password reset
├── admin/                 # Admin panel controllers
├── includes/              # Core functions and config
│   └── functions/         # Organized DB functions
└── templates/             # HTML views (public & admin)
```
