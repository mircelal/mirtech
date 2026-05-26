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

1. Copy the project into your web root (e.g. `www/mirtech`)
2. Open the site in your browser (e.g. `http://mirtech.local/`)
3. **Admin:** `/admin/login.php`  
   - Default password: **`admin1234`** (change before production!)
4. Configure contact & SMTP under **Admin → Settings**

Generate a new password hash:

```bash
php -r "echo password_hash('YOUR_PASSWORD', PASSWORD_BCRYPT);"
```

Put the result in `config.php` as `ADMIN_PASSWORD_HASH`.

---

## Project structure

```
mirtech/
├── index.php              # Homepage
├── projects.php           # Project list
├── project.php            # Project detail
├── technologies.php       # Tech stack
├── calculator.php         # Price calculator
├── config.php             # Config & helpers
├── api/lead.php           # Lead API (POST JSON)
├── admin/                 # Admin panel
├── assets/css|js/         # Styles & scripts
├── data/                  # JSON “database”
│   ├── projects.json
│   ├── technologies.json
│   ├── services.json
│   ├── settings.json
│   └── leads.json         # gitignored (privacy)
└── uploads/projects/      # Project images
```

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
2. Lead stored via `POST /api/lead.php`
3. Admin receives email (if SMTP is enabled)
4. User sees **“Request sent”** + optional WhatsApp button

---

## JSON data files

| File | Content |
|------|---------|
| `settings.json` | Site name, hero, contact, SMTP, stats |
| `projects.json` | Portfolio |
| `technologies.json` | Tech stack |
| `services.json` | Services |
| `leads.json` | Leads (not in git — create from `.example`) |

---

## Security

- Change the default admin password before going live
- `data/` is protected via `.htaccess`
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
