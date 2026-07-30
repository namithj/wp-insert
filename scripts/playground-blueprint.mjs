/**
 * Generates WordPress Playground blueprints for Wp-Insert.
 *
 * Wp-Insert has no post content to import — its state lives entirely in options
 * (`wp_insert_inpostads` and friends). So instead of a WXR import, the demo seeds
 * ad units directly and creates a sample post to display them on. The demo ad
 * code is deliberately self-contained inline HTML: Playground has no ad account,
 * and real network tags would simply render blank.
 *
 * Commands:
 *   bundle <output-path>                     Blueprint referencing a bundled zip.
 *   release-url <owner/repo> <tag>           Playground URL for a published release.
 *   branch-url <owner/repo> <branch>         Playground URL for a branch / PR head.
 */

import { writeFile } from 'node:fs/promises';

const PLUGIN_SLUG = 'wp-insert';

/**
 * PHP executed inside Playground once the plugin is active.
 *
 * Seeds one ad unit per placement type so every insertion path in the plugin is
 * visible at once, then creates a demo post and makes it the front page.
 */
const demoSetup = `<?php
require_once '/wordpress/wp-load.php';

$banner = static function ( $label, $colour ) {
	return '<div style="background:' . $colour . ';color:#fff;font:600 16px/1.4 system-ui,sans-serif;'
		. 'padding:22px;text-align:center;border-radius:6px;">' . $label
		. '<br><span style="font-weight:400;font-size:13px;opacity:.85;">Demo creative &mdash; your real ad code goes here</span></div>';
};

// A full ad unit as the admin form saves it. Only the fields a demo needs are
// set; everything else falls back to the plugin's defaults.
$unit = static function ( $title, $code, $extra = array() ) {
	return array_merge(
		array(
			'status'          => '1',
			'title'           => $title,
			'primary_ad_code' => $code,
			'styles'          => 'margin: 24px 0;',
		),
		$extra
	);
};

update_option(
	'wp_insert_inpostads',
	array(
		'demoabove'  => $unit( 'Above Post Content', $banner( 'In-Post Ad &mdash; above the content', '#2271b1' ), array( 'location' => 'above' ) ),
		'demomiddle' => $unit( 'Middle of Post Content', $banner( 'In-Post Ad &mdash; middle of the content', '#3858e9' ), array( 'location' => 'middle' ) ),
		'demobelow'  => $unit( 'Below Post Content', $banner( 'In-Post Ad &mdash; below the content', '#2271b1' ), array( 'location' => 'below' ) ),
	)
);

// Note: ad code is run through do_shortcode(), so demo labels must not contain
// literal shortcode syntax — it would be expanded away instead of displayed.
update_option(
	'wp_insert_shortcodeads',
	array(
		'demoshortcode' => $unit( 'Shortcode Ad', $banner( 'Shortcode Ad &mdash; positioned manually inside the content', '#8c1a5c' ) ),
	)
);

update_option(
	'wp_insert_adwidgets',
	array(
		'demowidget' => $unit( 'Sidebar Ad Widget', $banner( 'Ad Widget', '#0a4b78' ) ),
	)
);

update_option(
	'wp_insert_inthemeads',
	array(
		'demotheme' => $unit( 'In-Theme Ad', $banner( 'In-Theme Ad &mdash; called directly from a theme template', '#0a4b78' ) ),
	)
);

// Header / footer embed codes, shown as visible comments rather than real trackers.
update_option(
	'wp_insert_trackingcodes',
	array(
		'header' => array(
			'status' => '1',
			'code'   => '<!-- Wp-Insert demo: header embed code goes here -->',
		),
		'footer' => array(
			'status' => '1',
			'code'   => '<!-- Wp-Insert demo: footer embed code goes here -->',
		),
	)
);

$content = "<!-- wp:paragraph --><p>This demo post shows Wp-Insert inserting ads around and inside post content. "
	. "Each coloured block below is an ad unit configured in <strong>Wp Insert</strong> in the admin menu.</p><!-- /wp:paragraph -->\n\n"
	. "<!-- wp:paragraph --><p>Ad units are inserted automatically according to their placement rules: one above the content, "
	. "one detected midpoint of the content, and one below. No theme edits are required.</p><!-- /wp:paragraph -->\n\n"
	. "<!-- wp:paragraph --><p>The block below is placed manually with a shortcode, so you control exactly where it lands.</p><!-- /wp:paragraph -->\n\n"
	. "<!-- wp:shortcode -->[wpinsertshortcodead id=\\"demoshortcode\\"]<!-- /wp:shortcode -->\n\n"
	. "<!-- wp:paragraph --><p>Open <strong>Wp Insert</strong> from the admin menu to edit any of these units, change their "
	. "rules, or paste in your own iframe, JavaScript or HTML ad code.</p><!-- /wp:paragraph -->";

// The demo is a page set as the static front page, so the blueprint can land on
// '/' and always arrive somewhere ads are rendered — no post ID to guess and no
// permalink redirect. Wp-Insert's content placements apply to pages exactly as
// they do to posts.
$existing = get_page_by_path( 'wp-insert-demo', OBJECT, 'page' );
$demo_id  = $existing instanceof WP_Post ? $existing->ID : 0;

$postarr = array(
	'post_title'   => 'Wp-Insert demo',
	'post_name'    => 'wp-insert-demo',
	'post_content' => $content,
	'post_status'  => 'publish',
	'post_type'    => 'page',
);

if ( $demo_id ) {
	$postarr['ID'] = $demo_id;
	$demo_id       = wp_update_post( $postarr, true );
} else {
	$demo_id = wp_insert_post( $postarr, true );
}

if ( is_wp_error( $demo_id ) ) {
	throw new RuntimeException( 'Could not create the Wp-Insert demo page: ' . $demo_id->get_error_message() );
}

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', (int) $demo_id );
`;

export function createBlueprint( { pluginResource } ) {
	return {
		$schema: 'https://playground.wordpress.net/blueprint-schema.json',
		meta: {
			title: 'Wp-Insert demo',
			description:
				'Wp-Insert with sample ad units already configured for every placement type.',
			author: 'namithjawahar',
			categories: [ 'demo' ],
		},
		preferredVersions: {
			php: '8.2',
			wp: 'latest',
		},
		features: {
			networking: true,
		},
		landingPage: '/',
		login: true,
		steps: [
			{
				step: 'installPlugin',
				pluginData: pluginResource,
				options: {
					activate: true,
					targetFolderName: PLUGIN_SLUG,
				},
			},
			{
				step: 'runPHP',
				code: demoSetup,
			},
		],
	};
}

function encodePathSegment( value ) {
	return encodeURIComponent( value ).replaceAll( '%2F', '/' );
}

function encodeRepository( repository ) {
	return repository.split( '/' ).map( encodeURIComponent ).join( '/' );
}

function toPlaygroundUrl( blueprint ) {
	const encoded = Buffer.from( JSON.stringify( blueprint ) ).toString( 'base64' );
	return `https://playground.wordpress.net/#${ encoded }`;
}

async function main() {
	const [ command, ...args ] = process.argv.slice( 2 );

	if ( command === 'bundle' ) {
		const [ outputPath ] = args;

		if ( ! outputPath ) {
			throw new Error( 'Usage: playground-blueprint.mjs bundle <output-path>' );
		}

		const blueprint = createBlueprint( {
			pluginResource: { resource: 'bundled', path: `/${ PLUGIN_SLUG }.zip` },
		} );

		await writeFile( outputPath, `${ JSON.stringify( blueprint, null, 2 ) }\n` );
		return;
	}

	if ( command === 'release-url' ) {
		const [ repository, tag ] = args;

		if ( ! repository || ! tag ) {
			throw new Error(
				'Usage: playground-blueprint.mjs release-url <owner/repository> <tag>'
			);
		}

		const url = `https://github.com/${ encodeRepository( repository ) }/releases/download/${ encodePathSegment(
			tag
		) }/${ PLUGIN_SLUG }.zip`;

		process.stdout.write(
			toPlaygroundUrl( createBlueprint( { pluginResource: { resource: 'url', url } } ) )
		);
		return;
	}

	if ( command === 'branch-url' ) {
		const [ repository, branch ] = args;

		if ( ! repository || ! branch ) {
			throw new Error(
				'Usage: playground-blueprint.mjs branch-url <owner/repository> <branch>'
			);
		}

		// github-proxy.com is the proxy WordPress Playground uses to turn a GitHub
		// branch into an installable plugin zip; it is what makes PR previews work
		// without a published release.
		const url = `https://github-proxy.com/proxy/?repo=${ encodeURIComponent(
			repository
		) }&branch=${ encodeURIComponent( branch ) }`;

		process.stdout.write(
			toPlaygroundUrl( createBlueprint( { pluginResource: { resource: 'url', url } } ) )
		);
		return;
	}

	throw new Error(
		'Usage: playground-blueprint.mjs <bundle|release-url|branch-url> [arguments]'
	);
}

if ( import.meta.url === `file://${ process.argv[ 1 ] }` ) {
	main().catch( ( error ) => {
		console.error( error.message );
		process.exitCode = 1;
	} );
}
