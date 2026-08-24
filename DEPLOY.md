# Deploying the server-rendered PHP + MySQL build on cPanel

This branch (`php-server-rendered`) is a real PHP application: each page is its own
server-rendered `.php` file, backed by MySQL. Static content renders without a DB;
only the stateful flows (registration, contact, visitor pass, results, admin,
awards, login) use the database.

## 1. Upload
Copy the whole folder into cPanel `public_html/` (or a subfolder). Requires PHP 7.4+.
`index.php` is the default document. Make `uploads/` writable (0775) — registration
attachments (IBAN certificate, ID) are stored there.

## 2. Create the database (cPanel → MySQL Databases)
1. Create a database, e.g. `kalba_festival`.
2. Create a DB user and add it to that database with all privileges.

## 3. Import the schema (cPanel → phpMyAdmin)
Select the database and import `sql/schema.sql`.

## 4. Configure
Copy `config.sample.php` to `config.php` and fill in the DB host/name/user/pass.
`config.php` is gitignored so credentials never enter version control.

## 5. Seed the operator accounts + activity points
From the site directory on the server (cPanel → Terminal, or a cron one-off):

```
php tools/seed.php
```

This creates the operator accounts with real bcrypt password hashes and the
activity points. Default logins (change them):

| Username    | Password           | Role                         |
|-------------|--------------------|------------------------------|
| `admin`     | `Kalba@Admin-2026` | full admin                   |
| `organizer` | `Kalba@Award-2026` | award scanner + big screen   |
| `results`   | `Kalba@Scores-2026`| results + admin review       |

To change a password later, run on the server:
`php -r "echo password_hash('NewPass', PASSWORD_DEFAULT);"` and `UPDATE admin_users …`.

## Pages
`index.php` (home), `champs.php`, `champ.php?i=<n>`, `agenda.php`, `results.php`,
`leaderboard.php`, `venue.php`, `register.php` / `register.php?type=<t>`, `form.php`,
`pform.php?i=<n>`, `join.php`, `surveys.php`, `survey.php?k=<k>`, `community.php`,
`about.php`, `faq.php`, `contact.php`, `gallery.php`, `news.php`, `schools.php`,
`terms.php`, `privacy.php`, `gate.php` (staff login), `admin.php`, `award.php`,
`screen.php`, `my.php`. The interactive festival map stays as `map.html`.

Form handlers live in `actions/` and redirect back with a success/error flag.

## Notes
- `lang` is chosen by `?lang=ar|en` and remembered in a cookie (default Arabic RTL).
- The design system is `assets/style.css`; page interactivity is the small
  `assets/app.js` (countdown, carousel, scroll-reveal, mobile menu).
- Other branches: `main` = original single-file GitHub Pages build;
  `php-multipage` = per-page files sharing the client app bundle.
