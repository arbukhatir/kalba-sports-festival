# Kalba Sports Festival — Server-rendered PHP + MySQL rewrite

Goal: every page is its own server-rendered `.php` file backed by MySQL, deployable
on cPanel, keeping the existing cinematic design and all content. Driven with the
`superpowers` methodology (brainstorm → plan → execute in verifiable phases →
verify before claiming done).

## Architecture

```
config.sample.php   → copy to config.php on the server, fill DB creds (config.php gitignored)
lib/
  db.php            → PDO MySQL connection (lazy: only opened when a page needs data)
  i18n.php          → language (?lang=ar|en + cookie, default ar/RTL), t()/e() helpers
  render.php        → server-side component functions (pagehead, nav, footer, sport cards,
                      showcase, edition band, stat tiles) — the design system in PHP
  auth.php          → session login against admin_users, role/scope checks, audit log
data/
  content.php       → static content as PHP arrays: sports, schedule, forms, gallery,
                      news, faqs, i18n strings (ported faithfully from the old app.js)
partials/
  head.php header.php footer.php   → shared chrome (reuse assets/style.css)
sql/schema.sql      → MySQL DDL + seed (admin account, activity points)
actions/            → POST handlers: register, contact, subscribe, login, logout,
                      scores, app-status, points, award  (write to MySQL, redirect back)
assets/style.css    → existing design system (reused as-is)
assets/app.js       → SMALL progressive-enhancement JS only (countdown, carousel,
                      scroll-reveal, mobile nav, accordions, chatbot)
map.html            → interactive festival map (kept; already self-contained)
<page>.php          → one server-rendered file per page
```

Static content pages render with **no DB connection**; only stateful pages/actions
open MySQL, so the site degrades safely and the DB layer stays isolated.

## Database (MySQL)

Tables: `applications` (registrations), `matches` (fixtures + scores), `activities`
(points matrix), `visitors` (+ awarded points), `messages` (contact), `subscribers`
(newsletter), `survey_responses`, `audit_log`, `admin_users` (roles + per-sport scope).
`sql/schema.sql` creates them and seeds the admin/organizer/results accounts and the
activity points. Passwords stored as PHP `password_hash()`.

## Phases

- **Phase 1 — Foundation + content pages** (this branch, now):
  config, db, i18n, render lib, partials, schema.sql, data/content.php, and the
  server-rendered content pages: index, champs, champ, agenda, venue, about, faq,
  contact, gallery, news, schools, terms, privacy, surveys. Verified with `php -S`.
- **Phase 2 — Public stateful flows**: register (form + POST → applications),
  contact/subscribe, the survey submit, the visitor pass + points. MySQL-backed.
- **Phase 3 — Ops tools**: login gate (sessions), admin dashboard (applications
  review, settings), results/match entry, live leaderboard + big screen, award
  scanner. Role/scope enforced server-side.

## Verification

- Local: `php -l` on every file; `php -S 127.0.0.1:8123` to render content pages
  and check markup/CSS/images and zero console errors.
- DB: this dev box has no MySQL/pdo_mysql, so DB-backed flows are verified on the
  cPanel target after importing `sql/schema.sql` and setting `config.php`. DEPLOY.md
  documents the steps.

## Notes

- `main` keeps the original single-file `index.html` (GitHub Pages, no PHP).
- `php-multipage` keeps the SPA-in-partials version.
- `php-server-rendered` (this branch) is the MySQL backend build.
