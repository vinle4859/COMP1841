# Report Content - Student Forum System

This document contains pre-written content for the formal report.

---

## Table 1: Color Palette

| Module | Function | Hex Code | Description |
|--------|----------|----------|-------------|
| **Public** | Brand Header | #1A3C5E (Navy) | Primary brand colour for the navigation bar. |
| | Content Area | #FFFFFF (White) | Card containers for text readability. |
| | Background | #F4F6F8 (Light Gray) | Separates content cards from the page edge. |
| | Interactive | #4A90E2 (Blue) | Buttons and primary accents. |
| **Admin** | Dashboard Nav | #2C3E50 (Dark Slate) | Signals restricted backend environment. |
| | Background | #ECF0F1 (Cool White) | Distinct dashboard background. |
| | Create Button | #8E44AD (Purple) | Creative tasks (e.g., "Add Question"). |
| **Shared** | Warning | #E74C3C (Red) | High-risk actions (e.g., "Delete"). |
| | Success | #27AE60 (Green) | Positive feedback messages. |
| | Primary Text | #2C3338 (Charcoal) | Headings and body text. |

---

## Figure X: Navigation Structure

```
                              ┌─────────┐
                              │  Home   │
                              └────┬────┘
           ┌──────────┬───────────┼───────────┬──────────┐
           ▼          ▼           ▼           ▼          ▼
      ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐
      │Questions│ │   Ask   │ │ Contact │ │  Auth   │ │  Admin  │
      └────┬────┘ └────┬────┘ └─────────┘ └────┬────┘ └────┬────┘
           │           │                       │           │
      ┌────┴────┐      │              ┌────────┼────┐      │
      ▼         ▼      ▼              ▼        ▼    ▼      │
 ┌────────┐ ┌──────┐ ┌──────┐    ┌───────┐ ┌──────┐ │      │
 │ Detail │ │Filter│ │ Post │    │ Login │ │Signup│ │      │
 └────┬───┘ └──────┘ └──────┘    └───────┘ └──────┘ │      │
      │                                    ┌────────┘      │
 ┌────┴────┐                               ▼               │
 ▼         ▼                          ┌─────────┐          │
┌──────┐ ┌──────┐                     │ Profile │          │
│Answer│ │ Edit │                     └─────────┘          │
└──────┘ └──────┘                                          │
                         ┌─────────────────────────────────┘
                         │
        ┌────────┬───────┼───────┬────────┐
        ▼        ▼       ▼       ▼        ▼
   ┌─────────┐ ┌─────┐ ┌─────┐ ┌───────┐ ┌───────┐
   │Questions│ │Users│ │Inbox│ │Modules│ │Public │
   └────┬────┘ └──┬──┘ └──┬──┘ └───┬───┘ └───────┘
        │         │       │        │
   ┌────┴────┐ ┌──┴──┐ ┌──┴──┐ ┌───┴───┐
   ▼    ▼    ▼ ▼     ▼ ▼     ▼ ▼       ▼
 ┌───┐┌───┐┌───┐┌───┐┌───┐┌───┐┌───┐┌───┐
 │Add││Edt││Del││Add││Edt││Del││Add││Edt│
 └───┘└───┘└───┘└───┘└───┘└───┘└───┘└───┘
```

**Public Navigation:** Home → Questions → Ask Question → Contact → Login/Signup  
**Admin Navigation:** Questions → Users → Inbox → Modules → Back to Public Site

---

## Technologies Used

The system uses **PHP 8.x with PDO** (PHP Data Objects) for server-side processing and database interaction. PDO's prepared statements prevent SQL injection by separating query logic from user input (Nixon, 2021). **MySQL 8.x** stores all data with foreign key constraints ensuring referential integrity. User passwords are hashed using bcrypt via `password_hash()`. The front-end uses **semantic HTML5** elements and **CSS3** custom properties for consistent theming across public and admin interfaces.

---

## Legal, Ethical, and Security Considerations

### Web Accessibility (WCAG)

The Web Content Accessibility Guidelines (WCAG) 2.1, published by the World Wide Web Consortium (W3C), establish international standards for web accessibility (W3C, 2018). Under the Equality Act 2010, UK websites must be accessible to users with disabilities, making WCAG compliance a legal requirement for public-facing web services (GOV.UK, 2020).

The Student Forum implements several accessibility features aligned with WCAG Level AA:

- **Semantic HTML**: Using `<header>`, `<nav>`, `<main>`, and `<footer>` elements enables screen readers to navigate page structure effectively (W3Schools, 2024).
- **Colour Contrast**: The colour palette maintains a minimum contrast ratio of 4.5:1 between text (#2C3338) and backgrounds (#FFFFFF), meeting WCAG AA requirements.
- **Form Labels**: All form inputs are associated with descriptive `<label>` elements, ensuring assistive technologies can identify field purposes.
- **Keyboard Navigation**: Interactive elements are accessible via keyboard tabbing without requiring a mouse.

### Data Protection and GDPR

The General Data Protection Regulation (GDPR), retained in UK law as the UK GDPR following Brexit, governs how organisations process personal data (ICO, 2024). The Student Forum collects usernames, email addresses, and user-generated content, all classified as personal data under Article 4 of the regulation.

**Lawful Basis**: User registration constitutes consent for data processing. The contact form processes data under legitimate interest for responding to enquiries (ICO, 2024).

**Data Minimisation**: The system collects only essential data—username, email, and password—following GDPR's principle of collecting no more data than necessary (Article 5).

**Right to Erasure**: The system supports GDPR's "right to be forgotten" (Article 17) through a two-tier approach. Users may self-delete their account, which initiates a 30-day soft-delete grace period allowing recovery if requested. For immediate and complete data removal, users may contact an administrator via the contact form, who can manually anonymise the account by replacing personal identifiers while preserving discussion content integrity.

**Password Storage**: Passwords are never stored in plaintext. The bcrypt algorithm with automatic salting ensures that even database breaches cannot reveal original passwords (OWASP, 2023).

### Security Implementation

The system implements multiple security layers following OWASP guidelines (OWASP, 2023):

- **SQL Injection Prevention**: All database queries use PDO prepared statements with parameterised inputs.
- **Cross-Site Request Forgery (CSRF)**: Forms include unique tokens validated on submission, preventing malicious sites from submitting requests on behalf of authenticated users.
- **Session Security**: Session IDs are regenerated upon login to prevent session fixation attacks.
- **Input Validation**: Server-side validation sanitises all user inputs; client-side HTML5 validation provides immediate feedback.
- **Image Upload Validation**: The `getimagesize()` function verifies uploaded files are genuine images, preventing executable file uploads disguised as images.

---

## References

GOV.UK (2020) *Understanding accessibility requirements for public sector bodies*. Available at: https://www.gov.uk/guidance/accessibility-requirements-for-public-sector-websites-and-apps (Accessed: 30 November 2024).

ICO (2024) *Guide to the UK General Data Protection Regulation (UK GDPR)*. Information Commissioner's Office. Available at: https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/ (Accessed: 30 November 2024).

Nixon, R. (2021) *Learning PHP, MySQL & JavaScript*. 6th edn. Sebastopol: O'Reilly Media.

OWASP (2023) *OWASP Top Ten*. Open Web Application Security Project. Available at: https://owasp.org/www-project-top-ten/ (Accessed: 30 November 2024).

W3C (2018) *Web Content Accessibility Guidelines (WCAG) 2.1*. World Wide Web Consortium. Available at: https://www.w3.org/TR/WCAG21/ (Accessed: 30 November 2024).

W3Schools (2024) *HTML Accessibility*. Available at: https://www.w3schools.com/accessibility/index.php (Accessed: 30 November 2024).
