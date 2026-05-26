# MirTech — Open-source agency website (PHP)

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![JSON CMS](https://img.shields.io/badge/CMS-JSON%20files-333)](data/)

**Free, open-source corporate website template** for technology agencies and studios: portfolio, tech stack showcase, **smart price calculator**, admin panel, and lead capture (JSON + email).  
Built with **plain PHP** (no framework required), vanilla JavaScript, and CSS — easy to host on Laragon, XAMPP, or any shared hosting.

**Languages:** Azerbaijani (AZ) UI out of the box · easy to translate via JSON  
**Keywords:** php portfolio website, agency website template, project calculator, quote calculator, json cms php, laravel alternative lightweight, dev agency site, open source business website

---

## Features

- **Homepage** — hero, stats, featured projects, technologies, services
- **Projects** — filter, search, detail pages (timeline, progress, stats)
- **Technologies** — 80+ tools with Devicon icons, categories, search
- **Price calculator** — web, mobile, ERP, desktop, server; mobile-native UX (app bar, bottom sheet)
- **Admin panel** — manage projects, services, technologies, settings, leads
- **Lead system** — calculator submissions saved to JSON + email notification (SMTP / PHP `mail()`)
- **Lead detail view** — full calculator choices in admin
- **Mobile-friendly** — public site and admin panel

---

## Requirements

- PHP **8.1+** (`json`, `mbstring`, `openssl` recommended)
- Apache or Nginx (optional `mod_rewrite`)
- Laragon, XAMPP, or any PHP host

---

## Quick start

```bash
git clone https://github.com/mircelal/mirtech.git
cd mirtech
cp data/leads.json.example data/leads.json
```

1. Point your web server **document root** to `mirtech/public/` (see Laragon below).
2. Open the site (e.g. `http://mirtech.local/`).
3. **Admin:** `/admin/login.php` — default password **`admin1234`** (change before production!).
4. Configure contact & SMTP under **Admin → Settings**.

**Laragon (tövsiyə olunur):** Sağ klik layihə → **Web root** → `...\mirtech\public`  
Belə olanda URL-lər təmiz olur: `https://mirtech.local/projects.php?lang=es` (`/public/` yox).

Layihə kökü docroot qalsa belə, kök `.htaccess` URL-də `/public` göstərmir; köhnə `/public/...` linkləri avtomatik 301 ilə düzəlir.

**«Index of /» görürsünüzsə:** Document root hələ `mirtech/` qovluğundadır — kökdəki `.htaccess` + `index.php` işləməlidir; ən yaxşısı web root = `public`.

Generate a new password hash:

```bash
php -r "echo password_hash('YOUR_PASSWORD', PASSWORD_BCRYPT);"
```

Put the result in `config.user.php` as `define('ADMIN_PASSWORD_HASH', '...');` (copy from `config.user.php.example`).

---

## Project structure

```
mirtech/
├── public/                 # Document root (only this is web-exposed)
│   ├── index.php           # Stubs → core Controllers
│   ├── projects.php, project.php, …
│   ├── api.php             # ?action=lead
│   ├── admin/*.php         # Proxies to core/admin
│   ├── assets/             # CSS/JS (user-editable)
│   └── uploads/projects/   # Uploaded images
├── core/                   # Logic, admin, API (protected by .htaccess)
│   ├── bootstrap.php, helpers.php, Controllers/
│   └── admin/
├── views/                  # HTML templates (user-editable)
├── data/                   # JSON CMS (protected by .htaccess)
├── config.php              # Requires core/bootstrap.php
└── config.user.php         # Local overrides (gitignored)
```

### User vs core (updates)

| You may edit | Do not edit (core updates overwrite) |
|--------------|--------------------------------------|
| `views/**` | `core/**` |
| `public/assets/**` | `core/**`, `public/*.php` stubs |
| `public/uploads/**` | `data/**` (use admin panel) |
| `config.user.php` | Controllers, `core/bootstrap.php` |

`git pull` updates `core/` and `public/*.php` stubs; your `views/` and `public/assets/` stay intact.

### Wrong deployment (shared hosting)

- **Correct:** document root = `public/` only; `core/`, `data/`, `views/` sit **above** `public_html`.
- **Wrong:** copying the entire `mirtech/` tree into `public_html/` — then `core/` and `data/` might be reachable. `.htaccess` in `core/` and `data/` denies access as a last line of defense; still avoid exposing `views/` and `config.user.php`.

---

## Admin panel

| Section | URL |
|---------|-----|
| Login | `/admin/login.php` |
| Dashboard | `/admin/index.php` |
| Projects | `/admin/projects.php` |
| Services | `/admin/services.php` |
| Technologies | `/admin/technologies.php` |
| Leads | `/admin/leads.php` |
| Settings (SMTP, hero, …) | `/admin/settings.php` |

---

## Email (SMTP)

**Admin → Settings → Email / SMTP**

- SMTP host, port, TLS/SSL, credentials
- Notification email for new calculator leads
- Falls back to PHP `mail()` when SMTP is disabled  
- Test: `/admin/smtp-test.php`

---

## Calculator lead flow

1. User submits the form → **Send**
2. Lead stored via `POST /api.php?action=lead` (legacy: `/api/lead.php`)
3. Admin receives email (if SMTP is enabled)
4. User sees **“Request sent”** + optional WhatsApp button

---

## Multilingual (i18n)

Public site languages: **English (default)**, **Azerbaijani**, **Spanish**.

| Mechanism | Location |
|-----------|----------|
| Language config | `data/languages.json` |
| UI strings | `data/lang/en.json`, `az.json`, `es.json` |
| Content translations | `translations.{lang}` on `projects.json`, `services.json`, `settings.json`, `technologies.json` |
| Runtime API | `core/includes/i18n.php` — `t()`, `localized()`, `url()`, `langUrl()` |

**URL:** `?lang=az` or `?lang=es` (stored in session). Default language omits the query parameter.

**Admin:** **Dillər** (enable/default languages), **Tərcümələr** (UI keys), per-language tabs on projects/services/settings forms.

**One-time migration** (existing installs):

```bash
php scripts/migrate-i18n.php
```

This copies legacy top-level text into `translations.az` (and seeds EN/ES), creates lang packs, and backs up large JSON files.

To auto-fill **English and Spanish** content from your Azerbaijani texts (settings, services, all projects):

```bash
php scripts/translate-content.php
```

Creates `.bak-translate-*` backups. Edit fine-tuning per language in **Admin → Layihələr / Xidmətlər / Parametrlər** (language tabs) or **Tərcümələr** (UI strings).

## JSON data files

| File | Content |
|------|---------|
| `settings.json` | Site name, hero, contact, SMTP, stats |
| `projects.json` | Portfolio |
| `technologies.json` | Tech stack |
| `services.json` | Services |
| `leads.json` | Leads (not in git — create from `.example`) |

---

## PageSpeed / performans

- **Critical CSS** (hero + header) — ilk boyama tez
- **Async CSS:** Google Fonts, Font Awesome, Devicon (yalnız lazım olanda), `typography-az` (AZ)
- **`site.css` preload** + uzunmüddətli cache (`?v=filemtime`)
- **JS `defer`:** `site.js`, kalkulyator, layihə detalı
- **Şəkillər:** `width`/`height`, `lazy` / `fetchpriority="high"` (LCP)
- **`.htaccess`:** gzip/brotli, `Cache-Control` statik fayllar üçün

**Laragon:** Apache-də `mod_deflate` və `mod_expires` aktiv olsun. Production-da **HTTPS** və Web root = `public/`.

[PageSpeed Insights](https://pagespeed.web.dev/) ilə `https://mirtech.local/` yoxlayın.

---

## SEO (Google və ağıllı axtarış)

- **Canonical**, `meta robots`, **Open Graph**, **Twitter Card**
- **JSON-LD**: Organization, WebSite, WebPage, BreadcrumbList, layihə üçün CreativeWork
- **hreflang** (az / en / es) + **XML sitemap** (`/sitemap.xml`) + **robots.txt**
- Admin → **Parametrlər → SEO**: OG şəkil, Google doğrulama, sosial linklər

`contact.website_url` düzgün doldurun (məs. `https://mirtech.az`) — canonical və sitemap bunun üzərindən qurulur.

---

## Security

- Change the default admin password before going live
- `data/` and `core/` are protected via `.htaccess` (`Require all denied`)
- Document root must be `public/`
- Do not commit `leads.json` (personal data) or SMTP passwords
- Use HTTPS in production

---

## License — GPL-3.0 (copyleft)

This project is **free and open source** under the [GNU General Public License v3.0](https://www.gnu.org/licenses/gpl-3.0.html) (GPL-3.0-or-later).

**You may:**

- Use it for personal or commercial projects
- Modify and adapt it for your agency or clients
- Share it with others

**If you modify this software and distribute it** (including hosting a **modified** version for clients or the public), you **must** publish your **complete corresponding source code** under **GPL-3.0-or-later** (e.g. in a public Git repository). That way improvements stay available for everyone.

See [LICENSE](LICENSE) for the full notice.

---

## Contributing

Pull requests are welcome. By contributing, you agree that your changes will be licensed under GPL-3.0-or-later.

**Demo / upstream:** [github.com/mircelal/mirtech](https://github.com/mircelal/mirtech)

---

## Author

**[mircelal](https://github.com/mircelal)** — MirTech · [mirtech.az](https://mirtech.az)
