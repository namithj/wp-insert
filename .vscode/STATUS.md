# Wp-Insert Modernization — Status Log

Newest entries first. Update after every meaningful step.

## 2026-07-31 (session 1, continued)

- **P1 done**: site installed via wp-cli (ddev, WP 7.0.2, plugin active), composer
  deps in, phpcs baseline: 2,324 errors / 632 warnings (67 files).
- **P2 done**: PHPUnit + wp-phpunit 7.0 harness (`tests/phpunit/`, dedicated
  `wpinsert_tests` MySQL DB). `vendor/bin/phpunit` (+ `--group ajax`).
- **P3 done**: 87 characterization tests green — ad-code fidelity (iframe /
  AdSense / inline JS / raw HTML / shortcode / slashed) across all entry points,
  placements, rules gating, legacy data shapes. See TEST-MATRIX.md.
- **P4 done**: fixed `$adOptions` geo fatal (adunit.php), null-safe reads across
  frontend path, bare-variable warnings, gutenberg inverted isset, legacy title
  clobber in admin cards, `rand(1,0)` A/B mode normalization (+ function_exists
  guard on vi code branch).
- **P5 done (code)**: central `check_ajax_referer` capability guard
  (`manage_options`; `edit_posts` for gutenberg data), explicit checks in ad-unit
  get/save/delete, type whitelist (blocks arbitrary `wp_insert_*` option writes),
  identifier sanitization, removed `print_r` debug echo, kses fallback for users
  without `unfiltered_html` (raw storage preserved for those with it — round-trip
  proven byte-identical in AjaxSaveSecurityTest), legalpages kses_post, adstxt
  sanitize + esc_textarea, `die()`→`wp_die()` everywhere, trackingcodes option
  reads array-guarded. All 97 tests green.
- Noted for P7: jQuery UI CSS loaded from code.jquery.com CDN (must bundle);
  readme.txt stale; vi/google dead modules to remove.

## 2026-07-31

- Audited plugin architecture and rendering path; wrote PLAN.md.
- Found PHP 8 fatal-risk bug in `adunit.php:121` (undefined `$adOptions`).
- Environment: PHP 8.4.22, WP core 7.0.2 present at `/var/www/html/public` but
  site not yet installed; MySQL + wp-cli + Composer + Node available.
- Next: install site, composer install, phpcs baseline.
