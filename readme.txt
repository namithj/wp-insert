=== Wp-Insert ===
Contributors: namithjawahar
Donate link: https://wpinsert.smartlogix.co.in/support/
Tags: adsense, ad management, ads.txt, ad rotation, tracking codes
Requires at least: 6.3
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 2.6.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

The Ultimate Adsense / Ad-Management Plugin for WordPress.

== Description ==

Wp-Insert is a powerful yet easy to use ad management / ad insertion plugin which
does a lot more than ad management and insertion. Ad code from any network —
AdSense, iframes, JavaScript snippets or plain HTML — is inserted exactly as you
provide it.

= Features =

* Adsense optimised, with support for Auto Ads / Page-Level ads
* Unlimited ad blocks, with no artificial restrictions
* Insert ads above, below, to the left, to the right, or in the middle of post content with intelligent midpoint detection
* Insert ads after a chosen number of paragraphs, counting from the top or the bottom
* Insert ads into sidebars using ad widgets
* Insert ads into post content using shortcodes
* Insert ads directly into theme files, with the rules system still applied
* Gutenberg blocks for manual ad placement
* GUI driven rules system controlling when and where ads appear
* Exclude ads from specific posts, pages, categories, archives, search and 404 pages
* Hide ads for logged-in users or for mobile visitors
* Per-device targeting and styling for large desktop, medium desktop, tablet and mobile
* A/B testing across up to three ad networks, so only one network's ads appear at a time
* Country specific ad placement using a bundled, offline IP-to-country database
* Insert Google Analytics, Facebook Pixel or any other tracking code into the header or footer
* Supports shortcodes from other plugins inside ad blocks
* Authorized Digital Sellers (ads.txt) management with daily AdSense publisher-ID monitoring
* Legal page templates (Privacy Policy, Terms & Conditions, Disclaimer, Copyright) to kick-start your legal pages
* Compatible with the AMP plugin by Automattic and WooCommerce aware

== Installation ==

= In WordPress =

* Go in your Dashboard to 'Plugins' -> 'Add New'
* Search for 'Wp-Insert'
* Click on 'Install Now'
* Activate the plugin through the 'Plugins' menu in WordPress
* Open the 'Wp Insert' page from the admin menu

= Manually =

* Download the plugin
* Go in your Dashboard to 'Plugins' -> 'Add New'
* Click on 'Upload Plugin'
* Choose the downloaded zip file and click 'Install Now'
* Activate the plugin through the 'Plugins' menu in WordPress
* Open the 'Wp Insert' page from the admin menu

== Frequently Asked Questions ==

= Will my existing ad code keep working after updating? =

Yes. Ad code is stored and rendered exactly as you entered it, and the plugin ships
an automated test suite that verifies iframes, JavaScript snippets, AdSense code,
plain HTML and shortcodes all render byte-for-byte identically across every
placement type.

= Who can add or edit ad code? =

Only users with the `manage_options` capability (administrators on a single site).
Users who do not additionally have the `unfiltered_html` capability have their
input filtered through `wp_kses_post()` before it is saved.

= Where can I get support? =

Visit the [Wp-Insert support site](https://wpinsert.smartlogix.co.in/support/).

== External Services ==

This plugin does not send visitor data to any external service.

Country based ad targeting is resolved locally using an IP-to-country database
bundled with the plugin, so no visitor IP address leaves your server. Earlier
versions of Wp-Insert used the third-party freegeoip.net / ipstack APIs for this
feature; that is no longer the case.

Ad code that you add through the plugin may itself load resources from your ad
network (for example Google AdSense). Those requests are made by the ad code you
supply, are governed by that network's own privacy policy, and are entirely under
your control.

== Screenshots ==

1. The unified plugin admin page.
2. Rules system controlling when and where your ads are shown.
3. Geo-target different ads to audiences from specific countries.
4. Pre-prepared legal page templates to serve as a starting point.
5. Insert ads directly into your theme for advanced ad placement.
6. Multiple ad networks / A-B testing.
7. Google Analytics integration.
8. Embed codes in the header / footer.
9. Ad widgets which support the rules system.

== Changelog ==

= 2.6.0 =
* Modernisation release. Existing ad code and settings are preserved; no
  reconfiguration is required.
* Added an automated test suite covering ad-code rendering fidelity (iframes,
  JavaScript, AdSense, HTML, shortcodes) across every placement type, so updates
  cannot silently change how your ads are output.
* Fixed a fatal error on PHP 8 when a second geo-targeting country group was
  configured.
* Fixed numerous PHP 8.x warnings across the ad rendering path, including for ad
  units created by older versions of the plugin.
* Security: added capability checks to every admin AJAX endpoint, restricted ad
  data saving to known ad unit types, added nonce verification to the ads.txt
  AdSense reset action, and removed debug output from the ad save routine.
* Security: escaped all admin-side output, including the Google Analytics tracker
  ID which was previously written unescaped into an inline script.
* The jQuery UI stylesheet is now bundled with the plugin instead of being loaded
  from an external CDN.
* Country targeting no longer contacts a third-party geolocation API; lookups are
  resolved from a local database.
* Removed unused video intelligence and Google API modules that were shipped but
  never loaded.
* Removed the third-party ad network promotion from the ad code screen. The
  plugin no longer advertises any external service in the admin.
* The full codebase now passes the WordPress Coding Standards with no errors or
  warnings.

= 2.5.1 =
* Plugin header and coding standards updates.

== Upgrade Notice ==

= 2.6.0 =
Compatibility, security and coding standards release. Your existing ad units,
ad code and settings carry over unchanged.
