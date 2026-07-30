# WordPress.org Plugin Directory Compliance Audit — Wp-Insert 2.6.0

Audited against the 18 detailed plugin guidelines. Status as of 2026-07-31.

| # | Guideline | Status | Notes |
| --- | --- | --- | --- |
| 1 | GPL-compatible license | PASS | Plugin `GPLv2 or later` with License URI in header and readme. Bundled: iriven/GeoIPCountry (GPLv3 — compatible with "v2 or later"), Chart.js 2.x (MIT), jQuery UI smoothness theme (MIT). All carry license files. |
| 2 | Developer responsibility | PASS | No previously-removed code reinstated; all bundled assets have documented licenses. |
| 3 | Stable version in SVN | ACTION | Tag `2.6.0` in SVN when releasing; keep WP.org as the canonical build. |
| 4 | Human-readable code | PASS | No obfuscation. `Chart.bundle.min.js` ships with uncompressed source at `includes/assets/js/uncompressed/`. `jquery-ui.min.css` ships with a README naming its upstream source. |
| 5 | No trialware | PASS | Every feature works with no key, account or payment. No time limits, no quotas, no locked UI. |
| 6 | SaaS integrations | PASS | No SaaS dependency remains (video intelligence and Google API modules removed). |
| 7 | No external data collection | **FIXED** | Was: readme declared visitor IPs were sent to freegeoip.net / ipstack for geo targeting. Verified in code that `iriven\GeoIPCountry::resolve()` reads only the bundled `GeoIPDatas/` files — the downloader path requires `Admin()`, which the plugin never calls. No outbound request is made at runtime. Readme "External Services" section and the geo-targeting admin help text now state this accurately. |
| 8 | No remotely loaded executable code | **FIXED** | Was: jQuery UI stylesheet loaded from `code.jquery.com`. Now bundled at `includes/assets/css/jquery-ui/`. No remaining external asset loads, no `eval`, no self-update mechanism. |
| 9 | No illegal/dishonest behaviour | PASS | Nothing deceptive. Removing the inaccurate privacy claim (G7) also resolves an honesty concern. |
| 10 | No forced external links | PASS | No credit links, "powered by" markup, or backlinks in frontend output. Vendor links appear only inside the plugin's own admin screens. |
| 11 | No admin dashboard hijacking | PASS | Admin UI is a native WP page (no iframes). The ads.txt AdSense notice is dismissible and capability-gated. The third-party AdPushup promo that previously appeared in the in-post ad form has been removed, so no advertising remains in the admin. |
| 12 | No readme spam | **FIXED** | Was: 9 tags including "best adsense plugin". Now 5 relevant tags, no competitor terms, no affiliate links. |
| 13 | Use WordPress-bundled libraries | PASS | jQuery, jQuery UI core/accordion/dialog, editor and quicktags all loaded via core handles. Bundled Chart.js and the jQuery UI *theme CSS* are not shipped by core, so bundling is correct. |
| 14 | SVN is a release repository | ACTION | Development happens in git; commit to SVN only at release. |
| 15 | Increment version numbers | **FIXED** | Header `Version`, `WP_INSERT_VERSION` and readme `Stable tag` all now read `2.6.0` (was 2.5.1 with a stale readme). |
| 16 | Complete at submission | PASS | Feature-complete; no placeholders. Dead unloaded modules removed. |
| 17 | Trademarks | PASS | "Wp-Insert" / slug `wp-insert` does not lead with a third-party trademark. AdSense and Google are referenced descriptively, never as a name prefix. |
| 18 | WP.org reserves rights | N/A | Informational. |

## Other release-readiness fixes applied

- `Tested up to` raised from 6.1.1 to 7.0; `Requires at least: 6.3` and
  `Requires PHP: 7.4` added to the readme to match the plugin header.
- `.gitattributes` now `export-ignore`s `composer.json`, `/vendor`, `/tests` and
  `/.vscode` so the distributed archive contains no development files.
- Changelog and Upgrade Notice sections added, stating that existing ad code and
  settings carry over unchanged.

## Watch items (not violations, worth a decision before release)

1. **No `uninstall.php`** — deleting the plugin leaves ad units and settings in
   the options table. This is deliberate: wiping stored ad code on uninstall
   would destroy user data on a delete/reinstall cycle. Not a guideline
   requirement. If cleanup is ever added, it must be opt-in.
2. **Screenshots** — the readme lists nine screenshots; confirm the matching
   `assets/screenshot-N.png` files exist in the SVN `assets/` directory (they are
   not part of the plugin package).

## Resolved watch items

- **AdPushup promotional link** (was in `includes/modules/core/units/adcode.php`):
  removed entirely in 2.6.0. The plugin no longer promotes any third-party ad
  network in the admin, which removes the affiliate-disclosure question under
  Guideline 12 as well.
