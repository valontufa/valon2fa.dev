# valon2fa.dev — Personal Portfolio Theme

Custom WordPress theme built from scratch.  
No page builders. Tailwind CSS + AlpineJS + ACF Pro.

**Live:** https://valon2fa.dev

---

## Stack

| Layer | Technology |
|-------|------------|
| CMS | WordPress (custom theme) |
| CSS | Tailwind CSS v3 — compiled via PostCSS + Laravel Mix |
| JS | AlpineJS v3 — bundled via Laravel Mix |
| Content | ACF Pro — all fields registered programmatically |
| Fonts | Inter + JetBrains Mono — self-hosted woff2, no Google Fonts request |
| CPT | Projects — managed via wp-admin |
| Build | Laravel Mix 6 + webpack 5.74 |

---

## Requirements

- PHP 8.0+
- WordPress 6.0+
- ACF Pro (licence required)
- Node.js 16+ / npm

---

## Local Development (Docker)

```bash
# Clone the repo into your WordPress themes folder or run standalone
git clone https://github.com/valontufa/valon2fa-theme.git

# Start containers (WordPress + MySQL + phpMyAdmin)
docker compose up -d

# One-time WordPress install
make install

# Install and activate ACF Pro via wp-admin → Plugins → Upload Plugin
# Then seed initial content:
make seed
```

| URL | |
|-----|-|
| Site | http://localhost:8080 |
| wp-admin | http://localhost:8080/wp-admin |
| phpMyAdmin | http://localhost:8081 |
| Credentials | `admin` / `admin` |

---

## Theme Structure

```
valon2fa-theme/
├── inc/
│   └── admin-seed.php        — Tools → Seed Data page in wp-admin
├── template-parts/
│   ├── hero.php
│   ├── about.php
│   ├── how-i-work.php
│   ├── projects.php          — WP_Query loop for Projects CPT
│   ├── experience.php
│   └── contact.php
├── assets/
│   ├── css/main.css          — Tailwind source + custom components
│   ├── js/main.js            — AlpineJS init + IntersectionObserver animations
│   └── fonts/                — Self-hosted Inter + JetBrains Mono (woff2)
├── acf-json/                 — ACF field group JSON sync
├── front-page.php            — Homepage template
├── header.php                — Nav
├── footer.php                — Footer
├── functions.php             — Enqueue, CPT, ACF groups, performance
├── style.css                 — Theme header
├── docker-compose.yml
├── Makefile
├── package.json
├── tailwind.config.js
└── webpack.mix.js
```

---

## ACF Field Groups

All content is managed via ACF Pro. Fields are registered programmatically in `functions.php` — no GUI setup required.

| Section | Field Group | Fields |
|---------|-------------|--------|
| Hero | Hero Section | `hero_name`, `hero_keywords`, `hero_description`, `hero_availability_text` |
| About | About Section | `about_bio`, `about_stack_tags` (repeater), `about_cv_url` (file) |
| How I Work | How I Work Section | `work_paragraph_1`, `work_bullets` (repeater), `work_closing_line`, `work_tools` (repeater) |
| Experience | Experience Section | `experience_items` (repeater → nested `exp_bullets`) |
| Contact | Contact Section | `contact_heading`, `contact_description`, `contact_email`, `contact_linkedin_url` |
| Projects | Project Fields (CPT) | `project_tagline`, `project_tech_stack`, `project_live_url`, `project_github_url` |

---

## Development Workflow

```bash
# Install dependencies
npm install

# Watch mode — recompiles on file change
npm run watch

# Production build — minified output
npm run build
```

Output files (`assets/css/bundle.css`, `assets/js/bundle.js`) are gitignored. Always run `npm run build` after pulling changes.

---

## Seeding Content

On a fresh WordPress install, seed all ACF content and Projects from **wp-admin → Tools → Seed Data**.

This creates the Homepage page, sets it as the front page, and populates all field groups with default content. Safe to run once — warns before overwriting on re-run.

Alternatively via WP-CLI:

```bash
wp eval-file wp-content/themes/valon2fa-theme/seed.php
```

---

## Deployment

```bash
# 1. Push theme to server (Git or SFTP)
# 2. Build assets
npm run build

# 3. On first deploy only — install WordPress + ACF Pro, then:
#    wp-admin → Tools → Seed Data → Run Seed
#    (or wp eval-file seed.php via WP-CLI)

# Migrating from local to production — export DB and swap URLs:
wp db export backup.sql
wp db import backup.sql
wp search-replace 'http://localhost:8080' 'https://valon2fa.dev'
```

---

## Docker Commands

```bash
make up        # start containers
make down      # stop containers
make reset     # stop + wipe all volumes (full reset)
make logs      # tail WordPress logs
make seed      # run data seed via WP-CLI
make cli       # bash shell inside WordPress container
make wp <cmd>  # run any WP-CLI command, e.g. make wp plugin list
```
