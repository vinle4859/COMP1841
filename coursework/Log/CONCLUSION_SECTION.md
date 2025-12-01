# Conclusion

## Summary

The Student Forum prototype successfully implements all core coursework requirements: a public question list with search/filter, authenticated user CRUD for posts, module and user management, image attachments, and a contact form. Security controls include prepared statements, CSRF tokens, bcrypt password hashing, and rate limiting on login. Accessibility is addressed via semantic HTML landmarks, properly associated form labels, keyboard navigation, and WCAG AA colour contrast. Testing comprised 49 manual tests covering functional flows, input validation, security, and accessibility; seven bugs were discovered and fixed during iterative development. Additional features delivered include an admin dashboard, answer posting with accepted-answer toggle, view-count tracking, and soft-delete with restore capability for users and modules.

The system demonstrates the required learning outcomes: PHP/MySQL CRUD with PDO prepared statements and referential integrity; secure authentication; legal compliance (GDPR data minimisation and soft-delete); and basic accessibility compliance. While deliberately scoped as a prototype, the codebase is well-structured, documented through test logs and feature status, and ready for extension or production hardening.

## Future Development

- **Email & notifications**: SMTP integration for password-reset and contact-form emails (currently demo-mode only).
- **Performance**: Pagination for questions/answers; query optimisation; basic caching.
- **Accessibility**: Automated ARIA/contrast audits; explicit focus styles; skip-links.
- **Security**: HTTP-only cookies; Content Security Policy headers; strict input sanitisation.
- **Features**: Answer voting, user avatars, public profiles, bulk admin actions.
- **Developer experience**: Router/micro-framework, PSR-4 autoloading, component extraction.
- **Testing**: PHPUnit automated tests, CI pipeline, linting/formatting rules.

These are prioritised by impact: email and pagination deliver immediate value; accessibility and security address legal/user needs; refactoring and CI improve maintainability.
