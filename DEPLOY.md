# Deploying the PHP multipage build (cPanel)

Each page is a thin PHP file that assembles three shared partials and boots the
single-page app to one view:

- `partials/head.php`   — `<head>`, meta, CSP, fonts, `assets/style.css`
- `partials/header.php` — skip link, top navigation, `<main id="app">`
- `partials/footer.php` — footer, chatbot, the `window.__BOOT` view/arg, `assets/app.js`
- `assets/style.css`    — the whole design system (was the inline `<style>`)
- `assets/app.js`       — the whole application (was the inline `<script>`)

## Pages
`index.php` (home), `champs.php`, `champ.php?i=<n>`, `agenda.php`, `results.php`,
`leaderboard.php`, `venue.php`, `register.php?type=<t>`, `form.php?type=<t>`,
`join.php`, `surveys.php`, `survey.php?k=<k>`, `community.php`, `about.php`,
`faq.php`, `contact.php`, `gallery.php`, `news.php`, `schools.php`, `terms.php`,
`privacy.php`, `admin.php`, `award.php?code=<c>`, `screen.php`, `gate.php`,
`pform.php?i=<n>`, `my.php`. The interactive map stays as `map.html`.

In-app navigation stays instant (the client router swaps `#app`); the PHP files
are real entry points and deep links, and let the source live one page per file.

## Upload
Copy the whole folder to cPanel `public_html/` (or a subfolder). Requires PHP 7+;
no database. `index.php` is the default document. Nothing else to configure.

## Note on GitHub Pages
GitHub Pages cannot execute PHP, so this build is for a PHP host (cPanel). The
`main` branch keeps the original single-file `index.html` for GitHub Pages.
