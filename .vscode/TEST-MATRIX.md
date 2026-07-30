# Ad-Code Compatibility Test Matrix

Purpose: prove that ad code saved by existing users renders identically after the
modernization. Tests live in `tests/phpunit/tests/`.

## Ad code fixtures (types users actually store)

| Fixture | Content |
| --- | --- |
| iframe | `<iframe src=... width height frameborder scrolling>` banner embed |
| adsense | Real-world async AdSense snippet (multiline `<script>` + `<ins>` + push) |
| inline JS | `<script>` with `document.write`, mixed single/double quotes |
| raw HTML | `<div><a><img>` banner markup with inline styles |
| shortcode | Ad code containing a shortcode — must be expanded by `do_shortcode` |
| slashed | Stored code containing backslash-escaped quotes — `stripslashes()` applied at render (legacy behavior, must be preserved) |

## Entry points × fixtures

| Entry point | Mechanism | Tested in |
| --- | --- | --- |
| `wp_insert_get_ad_unit_code()` | core code selection (A/B modes 1/2/3, geo groups) | AdUnitCodeTest |
| `wp_insert_get_ad_unit()` | wrapper div + responsive `<style>` block, float styles | AdUnitWrapperTest |
| `the_content` (prio 100) | above / below / middle / left / right / paragraphtop / paragraphbottom; legacy keyed units (`above` etc. without `location`); min-char-count; paragraph buffer; shortcode-override suppression; feed exclusion | InPostPlacementTest |
| `[wpinsertinpostad id=]` | manual in-post positioning | ShortcodeAdsTest |
| `[wpshortcodead]` / `[wpinsertshortcodead]` | shortcode ads (legacy + current tag) | ShortcodeAdsTest |
| `wp_intheme_ad()` / `wp_template_ad()` | theme functions (echo; `wp_template_ad` maps to `templateads-` prefix) | InThemeAdsTest |
| `wpInsertAdWidget` | widget output incl. title | WidgetTest |
| `wp_head` page-level ads | raw code, no wrapper | HeadFooterCodesTest |
| `wp_head`/`wp_footer` tracking codes | raw embed codes, `stripslashes` | HeadFooterCodesTest |
| `wp_insert_get_ad_status()` | status flag, logged-in/mobile exclusions, page-type rules | AdStatusRulesTest |

## Data-shape compatibility

- **Full shape**: every field the admin form saves (see `AdFixtures::full_ad_unit()`),
  empty-string for untouched fields — what current-version users have stored.
- **Legacy shape** (`@group php8-compat`): pre-2.x units keyed `above|middle|below|left|right`
  with no `location`, and minimal units missing modern fields. Must render without
  PHP 8 warnings/fatals after P4.
- **Geo shape**: `geo_group1_countries`/`geo_group2_countries` as arrays + geo ad codes
  (exposes the `$adOptions` bug at adunit.php:121).

## Invariant assertion style

Wrapper class name is random per render — tests extract it via regex and assert the
inner ad code is **byte-identical** to the expected rendering of the stored code.
