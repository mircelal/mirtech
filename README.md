# MirTech — Korporativ veb sayt

MirTech texnologiya şirkəti üçün hazırlanmış korporativ veb sayt: layihə portfeli, texnologiya stack-i, ağıllı qiymət kalkulyatoru və admin panel.

**Dil:** Azərbaycan (AZ)  
**Stack:** PHP 8+, JSON data, vanilla JavaScript, CSS

---

## Xüsusiyyətlər

- **Ana səhifə** — hero, statistika, seçilmiş layihələr, texnologiyalar, xidmətlər
- **Layihələr** — filtr, axtarış, layihə detalları (timeline, progress, statistika)
- **Texnologiyalar** — kateqoriya və axtarış ilə 80+ texnologiya (Devicon ikonları)
- **Qiymət kalkulyatoru** — veb, mobil, ERP, desktop, server; mobil native UX (app bar, bottom sheet)
- **Admin panel** — layihə, xidmət, texnologiya, parametrlər, müraciətlər idarəetməsi
- **Müraciət sistemi** — kalkulyator sorğuları panelə yazılır + email bildirişi (SMTP / PHP mail)
- **Mobil optimizasiya** — bütün əsas səhifələr və admin panel

---

## Tələblər

- PHP **8.1+** (`json`, `mbstring`, `openssl` tövsiyə olunur)
- Apache / Nginx (mod_rewrite optional)
- Laragon, XAMPP və ya istənilən PHP host

---

## Quraşdırma

```bash
# Repozitoriyanı klonlayın
git clone https://github.com/mircelal/mirtech.git
cd mirtech

# Laragon: www/mirtech qovluğuna yerləşdirin
# Virtual host: mirtech.local
```

1. Layihəni veb serverin `document root`-una (məs. `www/mirtech`) kopyalayın
2. `data/leads.json` yaradın (və ya `data/leads.json.example`-dan kopyalayın):

```bash
cp data/leads.json.example data/leads.json
```

3. Brauzerdə saytı açın: `http://mirtech.local/`
4. **Admin şifrəsini dəyişin** — `config.php` faylında `ADMIN_PASSWORD_HASH`:

```php
php -r "echo password_hash('YENI_SIFRE', PASSWORD_BCRYPT);"
```

5. Admin panel: `/admin/login.php`

---

## Struktur

```
mirtech/
├── index.php              # Ana səhifə
├── projects.php           # Layihələr siyahısı
├── project.php            # Layihə detalları
├── technologies.php       # Texnologiyalar
├── calculator.php         # Qiymət kalkulyatoru
├── config.php             # Əsas konfiqurasiya və helper funksiyalar
├── api/
│   └── lead.php           # Kalkulyator sorğu API (POST JSON)
├── admin/                 # Admin panel
├── assets/css/            # site.css, typography-az.css
├── assets/js/             # calculator.js, site.js
├── data/                  # JSON məlumat bazası
│   ├── projects.json
│   ├── technologies.json
│   ├── services.json
│   ├── settings.json
│   └── leads.json         # gitignore — müraciətlər
├── includes/              # header, footer, mail, tech-icon
└── uploads/projects/      # Layihə şəkilləri
```

---

## Admin panel

| Bölmə | URL |
|--------|-----|
| Giriş | `/admin/login.php` |
| Panel | `/admin/index.php` |
| Layihələr | `/admin/projects.php` |
| Xidmətlər | `/admin/services.php` |
| Texnologiyalar | `/admin/technologies.php` |
| Müraciətlər | `/admin/leads.php` |
| Parametrlər (SMTP) | `/admin/settings.php` |

Müraciətlər kalkulyator formundan avtomatik `data/leads.json`-a yazılır.

---

## Email (SMTP)

Admin → **Parametrlər** → SMTP bölməsi:

- Host, port, TLS/SSL
- İstifadəçi adı və şifrə
- Bildiriş emaili (`notify_email`)

SMTP aktiv deyilsə, sistem PHP `mail()` ilə fallback edir (server konfiqurasiyasından asılıdır).

Test: `/admin/smtp-test.php`

---

## Kalkulyator sorğu axını

1. İstifadəçi kalkulyatorda məlumat doldurur → **Göndər**
2. Sorğu `POST /api/lead.php` ilə saxlanılır
3. Adminə email göndərilir (SMTP aktivdirsə)
4. İstifadəçiyə **«Sorğu göndərildi»** + WhatsApp düyməsi göstərilir

---

## Məlumat faylları

Bütün məzmun JSON fayllarında saxlanılır (`data/`). Admin paneldən redaktə oluna bilər; birbaşa JSON redaktəsi də mümkündür.

| Fayl | Məzmun |
|------|--------|
| `settings.json` | Sayt adı, hero, əlaqə, SMTP, statistika |
| `projects.json` | Layihələr |
| `technologies.json` | Texnologiya stack |
| `services.json` | Xidmətlər |
| `leads.json` | Kalkulyator müraciətləri (git-ə daxil deyil) |

---

## Təhlükəsizlik

- Admin şifrəsini production-da mütləq dəyişin
- `data/` qovluğu `.htaccess` ilə qorunur
- `leads.json` repozitoriyaya daxil edilmir (şəxsi məlumat)
- SMTP şifrəsini repoya commit etməyin

---

## Lisenziya

Proprietary — MirTech © 2026
