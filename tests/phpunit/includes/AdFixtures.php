<?php
/**
 * Shared ad-code fixtures and data-shape factories for the test suite.
 *
 * The fixtures mirror the kinds of ad code real users have stored: iframes,
 * async/inline JavaScript snippets, raw HTML and shortcodes. The data shapes
 * mirror what the admin form actually persists to the options table.
 *
 * @package wp-insert
 */

trait AdFixtures {

	/**
	 * Iframe banner embed.
	 *
	 * @var string
	 */
	public static $ad_iframe = '<iframe src="https://ads.example.com/frame?id=42&size=300x250" width="300" height="250" frameborder="0" scrolling="no" style="border:none;"></iframe>';

	/**
	 * Real-world style async AdSense snippet (multiline).
	 *
	 * @var string
	 */
	public static $ad_adsense = "<script async src=\"https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1234567890123456\" crossorigin=\"anonymous\"></script>\n<!-- responsive-unit -->\n<ins class=\"adsbygoogle\"\n     style=\"display:block\"\n     data-ad-client=\"ca-pub-1234567890123456\"\n     data-ad-slot=\"9876543210\"\n     data-ad-format=\"auto\"\n     data-full-width-responsive=\"true\"></ins>\n<script>\n     (adsbygoogle = window.adsbygoogle || []).push({});\n</script>";

	/**
	 * Inline JavaScript with mixed quoting.
	 *
	 * @var string
	 */
	public static $ad_inline_js = "<script type=\"text/javascript\">\nvar ad_network = 'legacy';\ndocument.write('<a href=\"https://example.net/click\"><img src=\"https://example.net/banner.gif\" alt=\"Ad\"></a>');\n</script>";

	/**
	 * Raw HTML banner markup.
	 *
	 * @var string
	 */
	public static $ad_html = '<div class="my-banner" style="text-align:center;"><a href="https://sponsor.example.org/?utm_source=site" rel="nofollow sponsored"><img src="https://sponsor.example.org/banner-728x90.png" width="728" height="90" alt="Sponsor"></a></div>';

	/**
	 * All ad-code fixtures, keyed by a human-readable label.
	 *
	 * @return array
	 */
	public static function ad_code_fixtures() {
		return [
			'iframe'    => [ self::$ad_iframe ],
			'adsense'   => [ self::$ad_adsense ],
			'inline js' => [ self::$ad_inline_js ],
			'raw html'  => [ self::$ad_html ],
		];
	}

	/**
	 * Full data shape as persisted by wp_insert_save_ad_data(): every form field
	 * present, empty string when the user left it untouched.
	 *
	 * @param array $overrides Field overrides.
	 * @return array
	 */
	public static function full_ad_unit( array $overrides = [] ) {
		$defaults = [
			'status'                           => '1',
			'identifier'                       => 'testunit01',
			'title'                            => 'Test Unit',
			'primary_ad_code'                  => self::$ad_html,
			'secondary_ad_code'                => '',
			'tertiary_ad_code'                 => '',
			'styles'                           => '',
			'notes'                            => '',
			'geo_group1_countries'             => '',
			'geo_group1_adcode'                => '',
			'geo_group2_countries'             => '',
			'geo_group2_adcode'                => '',
			'rules_exclude_loggedin'           => '',
			'rules_exclude_mobile_devices'     => '',
			'rules_exclude_home'               => '',
			'rules_home_instances'             => '',
			'rules_exclude_archives'           => '',
			'rules_archives_instances'         => '',
			'rules_exclude_search'             => '',
			'rules_search_instances'           => '',
			'rules_exclude_page'               => '',
			'rules_page_exceptions'            => '',
			'rules_exclude_post'               => '',
			'rules_post_exceptions'            => '',
			'rules_post_categories_exceptions' => '',
			'rules_exclude_categories'         => '',
			'rules_categories_exceptions'      => '',
			'rules_categories_instances'       => '',
			'rules_exclude_404'                => '',
			'device_large_desktop_width'       => '',
			'device_large_desktop_adwidth'     => '',
			'device_large_desktop_styles'      => '',
			'device_exclude_large_desktop'     => '',
			'device_medium_desktop_width'      => '',
			'device_medium_desktop_adwidth'    => '',
			'device_medium_desktop_styles'     => '',
			'device_exclude_medium_desktop'    => '',
			'device_tablet_width'              => '',
			'device_tablet_adwidth'            => '',
			'device_tablet_styles'             => '',
			'device_exclude_tablet'            => '',
			'device_mobile_width'              => '',
			'device_mobile_adwidth'            => '',
			'device_mobile_styles'             => '',
			'device_exclude_mobile'            => '',
			'device_small_mobile_adwidth'      => '',
			'device_small_mobile_styles'       => '',
			'device_exclude_small_mobile'      => '',
		];
		return array_merge( $defaults, $overrides );
	}

	/**
	 * Legacy (pre-2.x) minimal data shape: units keyed by location with only the
	 * fields that existed at the time.
	 *
	 * @param array $overrides Field overrides.
	 * @return array
	 */
	public static function legacy_ad_unit( array $overrides = [] ) {
		$defaults = [
			'status'          => '1',
			'primary_ad_code' => self::$ad_html,
		];
		return array_merge( $defaults, $overrides );
	}

	/**
	 * Replace the random per-render wrapper class names (5 letters + uniqid)
	 * with a stable token so outputs can be compared byte-for-byte.
	 *
	 * @param string $html Markup containing zero or more rendered ad units.
	 * @return string
	 */
	public static function normalize_ad_classes( $html ) {
		return preg_replace( '/[a-z]{5}[0-9a-f]{13}/', 'ADCLS', $html );
	}

	/**
	 * Extract the randomly-named wrapper and return [ class, inner code, styles ].
	 *
	 * @param string $html Rendered ad unit markup.
	 * @return array|null
	 */
	public static function parse_ad_unit( $html ) {
		if ( ! preg_match( '#^<div class="([a-z0-9]+)"\s*(?:style="([^"]*)")?>(.*)</div>(<style type="text/css">.*</style>\r\n)$#s', $html, $m ) ) {
			return null;
		}
		return [
			'class'  => $m[1],
			'style'  => $m[2],
			'code'   => $m[3],
			'styles' => $m[4],
		];
	}
}
