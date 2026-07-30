# Wp-Insert Modernization Plan

Goal: bring Wp-Insert 2.5.1 to current WordPress coding standards, add an elaborate
test suite, guarantee existing users' stored ad codes (iframes, JS snippets, raw HTML,
shortcodes) render identically after the update, and satisfy WordPress.org plugin
directory rules for a new release.

## Current architecture (as-audited)

- Procedural "module" structure: `includes/modules/core/*` (admin UI, controls,
  ad units, rules, geo, ads.txt, gutenberg) and `includes/modules/general/*`
  (inpost, widgets, shortcode, intheme, pagelevel, trackingcodes, legalpages).
- Ad data lives in options keyed by unit type: `wp_insert_inpostads`,
  `wp_insert_adwidgets`, `wp_insert_shortcodeads`, `wp_insert_inthemeads` —
  each an array of `identifier => { title, status, primary_ad_code,
  secondary_ad_code, tertiary_ad_code, location, rules_*, geo_*, device_*, styles, ... }`.
- Rendering path (MUST NOT change output semantics):
  - `wp_insert_get_ad_unit( $data )` → `<div class="{random}">` + ad code + responsive `<style>` block.
  - `wp_insert_get_ad_unit_code()` → `do_shortcode( stripslashes( $code ) )` — raw, unescaped by design (ad codes are trusted admin input).
  - Entry points: `the_content` filter (prio 100, in-post placements above/middle/below/left/right/paragraphtop/paragraphbottom), shortcodes `[wpinsertinpostad]`, `[wpshortcodead]`, `[wpinsertshortcodead]`, theme functions `wp_intheme_ad()` / `wp_template_ad()` (back-compat), widget `wpInsertAdWidget`, header/footer tracking codes.
  - `wp_insert_get_ad_status( $rules )` gates every placement (status flag, AMP/Woo, logged-in, mobile, page-type rules).

## Known defects found during audit

1. `includes/modules/core/units/adunit.php:121` — references undefined `$adOptions`
   (`count( $adOptions['geo_group1_countries'] )`); TypeError/fatal on PHP 8 when
   geo group 2 countries are set. Should be `$data['geo_group2_countries']`.
2. PHP 8.x undefined-index/undefined-variable warnings throughout the frontend path
   (`$data['geo_group1_countries']`, `$data['primary_ad_code']`, `$inpostad['paragraph_buffer_count']`, etc.) — code predates null-coalescing.
3. `wp_insert_save_ad_data()` echoes `print_r` debug output; no `current_user_can()`
   capability checks in any AJAX handler (nonce only); saves `$_POST` unsanitized/unslash-less.
4. Widget uses `extract()`; admin markup largely unescaped; hardcoded strings not i18n'd.
5. readme.txt: "Tested up to: 6.1.1" stale; tag list too long (12 tags, limit 5);
   external service (ipstack/freegeoip, vi.ai) disclosure needs the current required format.
6. Dead/disabled modules still shipped: `videointelligence`, `google` (commented out
   in `general/modules.php`) — candidates for removal before WP.org submission.

## Phases

- [ ] **P0 — Tracking docs** (this file, STATUS.md)
- [ ] **P1 — Environment + baseline**: install the local WP site (wp-cli + MySQL),
  `composer install`, record phpcs baseline counts, activate plugin, smoke-test.
- [ ] **P2 — Test scaffold**: PHPUnit + `wp-phpunit/wp-phpunit` + Yoast polyfills
  against local MySQL; `tests/phpunit/` bootstrap; composer `test` script wired.
- [ ] **P3 — Characterization tests (write BEFORE refactoring)**: pin current
  rendering behavior so later changes can't silently break users' ads. Matrix in
  TEST-MATRIX.md — iframe / async JS (adsense) / inline JS / raw HTML / shortcode /
  multiline + quoted codes, across every placement entry point, plus rules gating,
  A/B modes, device styles, legacy data shapes (`above`/`middle` keyed units without
  `location`, units missing new fields).
- [ ] **P4 — PHP 8.x + bug fixes**: fix adunit geo bug, null-safe reads across
  frontend path; tests must stay green.
- [ ] **P5 — Security hardening**: capability checks (`manage_options` +
  `unfiltered_html` for raw script storage), sanitize/unslash all `$_POST` reads,
  escape all admin-side output, remove debug output, keep ad-code storage lossless
  (tests prove round-trip fidelity).
- [ ] **P6 — Coding standards**: phpcs (WordPress-Extra) clean or documented
  ignores; remove `extract()`; i18n all user-facing strings.
- [ ] **P7 — WP.org compliance**: readme.txt rewrite (Tested up to 6.9/7.0, ≤5 tags,
  Stable tag bump, external-services section), plugin-directory-guidelines audit,
  drop dead modules, verify GPL compat of bundled assets (Chart.js has uncompressed
  source ✓, GeoIP lib license check).
- [ ] **P8 — Final verification**: full suite + lint green, version bump, STATUS.md
  updated, commits.

## Invariants (never violate)

1. Stored ad code must render byte-identical (modulo the random wrapper class name)
   before and after every change. Characterization tests enforce this.
2. Option names, shortcode tags, public function names (`wp_intheme_ad`,
   `wp_template_ad`), widget id `wp_insert_ad_widget`, and hook names are public
   API — do not rename.
3. Legacy data shapes (pre-2.x keyed units, missing fields) must keep working.
