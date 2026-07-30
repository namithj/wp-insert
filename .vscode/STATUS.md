# Wp-Insert Modernization — Status Log

Newest entries first. Update after every meaningful step.

## 2026-07-31 — 2.6.0 ready for release

**P6/P7/P8 complete. All phases done.**

- **phpcs: 0 errors, 0 warnings** (baseline was 2,324 / 632). Ruleset documents
  every deliberate exclusion — loose comparisons and loose `in_array()` are
  load-bearing for mixed-type stored data and would break existing installs if
  made strict; camelCase locals are kept to minimize regression risk.
- Introduced `wp_insert_echo_html()` / `wp_insert_echo_ad_code()` with documented
  escaping contracts, registered as `customEscapingFunctions` in phpcs.xml.dist,
  so raw ad output is explicit rather than an unexplained ignore comment.
- Real escaping bugs fixed along the way: Google Analytics tracker ID was
  interpolated unescaped into an inline `<script>`; ad-unit titles/keys were
  interpolated unescaped into inline JS handler arguments; the ads.txt AdSense
  reset was a state-changing GET with no nonce.
- Widget rewritten: `extract()` removed, `update()` sanitizes, form escaped and
  i18n'd, class moved to `class-wpinsertadwidget.php`.
- Rewrote `wp_insert_inpostads_get_insertion_position()` — the old `switch` only
  worked by accident of loose bool comparison. Behavior pinned by tests.
- Bundled the jQuery UI smoothness theme locally (was a `code.jquery.com` CDN
  load — a Guideline 8 violation).
- Removed unshipped `videointelligence` and `google` modules plus vi image assets.
- **Verified the privacy claim rather than trusting the old readme**: read
  `GeoIPCountry::resolve()` and confirmed it reads only bundled `GeoIPDatas/`
  files; the downloader requires `Admin()`, which the plugin never calls. The
  readme previously told users their visitors' IPs were sent to freegeoip.net /
  ipstack. Corrected in both the readme and the geo-targeting admin help text.
- readme.txt rewritten: 2.6.0, Tested up to 7.0, tags 9 → 5, added Changelog,
  Upgrade Notice and External Services sections.
- Version bumped to 2.6.0 in header, `WP_INSERT_VERSION` and Stable tag.
- Added `bin/build-release.sh` (git-archive based, refuses to build on a
  header/readme version mismatch). Verified output zip has **zero** dev files.
- **Live-site verification** beyond unit tests: seeded legacy 2.5.1-shaped data
  (`above`/`middle` keys, no `location` field) into the real dev site and fetched
  a post over HTTPS — iframe ad prepended, JS ad at the midpoint, header embed
  raw in `<head>`, no PHP notices.
- Final: 87 tests + 10 AJAX tests green, phpcs clean, `php -l` clean.

### Open item

One PHPUnit run reported `Tests: 87, Assertions: 143, Errors: 1` without naming
the failing test. It has **not** reproduced in 14 subsequent runs, including
three with `--random-order`, so the failing test was never identified. Treat it
as suspected environment flake (ddev DB), not as verified-clean. If it recurs,
capture the full output immediately.

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
